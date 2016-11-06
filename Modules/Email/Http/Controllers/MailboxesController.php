<?php
namespace Modules\Email\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Config;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Services\Setting\SettingServiceContract;
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\MailboxProtocol;
/*
use Modules\Core\Requests\EmailsEditRequest;
use Modules\Core\Requests\EmailsRequest;
use Modules\Core\Models\Department;
// model
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\Help_topic;
use Modules\Email\Models\Mailbox;
use Modules\Email\Models\TicketPriority;

*/

use Crypt;
// classes
use Exception;


class MailboxesController extends Controller
{


    public function __construct()
    {
        //$this->middleware('staff');
        ////$this->middleware('roles');
        //$this->middleware('mailbox.create', ['only' => ['create']]);
        //$this->middleware('mailbox.update', ['only' => ['edit']]);
    }


    public function maildashboard()
    {
        return view('email::mail.maildashboard');
    }

    public function anyData()
    {
        $mailboxes = Mailbox::select([
            'id', 'email_address', 'email_name', 'is_active', 'fetching_status', 'sending_status', 'mailbox_type',
            'department_id', 'priority_id', 'updated_at'
        ]);

        return Datatables::of($mailboxes)
            ->addColumn('mailboxlink', function ($mailboxes) {
                return '<a href="/mailpanel/inbox/' . $mailboxes->id . '">' . $mailboxes->email_name . '</a>';
            })
            ->addColumn('mailaddress', function ($mailboxes) {
                return $mailboxes->email_address;
            })

            ->addColumn('mailboxtype', function ($mailboxes) {
                return $mailboxes->mailbox_type;
            })

            ->addColumn('isactive', function ($mailboxes) {
                return $mailboxes->is_active;
            })

            ->addColumn('fetching_status', function ($mailboxes) {
                return $mailboxes->fetching_status;
            })

            ->addColumn('sending_status', function ($mailboxes) {
                return $mailboxes->sending_status;
            })

            ->addColumn('department', function ($mailboxes) {
                return $mailboxes->department_id;
            })
            ->addColumn('actions', function ($mailboxes) {
                return '
                <form action="' . route('admin.mailboxes.mailbox.destroy', [$mailboxes->id]) . '" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('admin.mailboxes.mailbox.edit', [$mailboxes->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }


    public function index()
    {
        return view('mailboxes.index');
    }

    public function manage()
    {
        return view('email::mailboxes.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param type Department      $department
     * @param type Help_topic      $help
     * @param type Priority        $priority
     * @param type MailboxProtocol $mailbox_protocol
     *
     * @return type Response
     */
    public function create(MailboxProtocol $mailbox_protocol)
    {
        try {
            // fetch all the types of mailbox protocols from the mailbox_protocols table
            $mailbox_protocols = $mailbox_protocol->get();
            // return with all the table data
            return view('email::mailboxes.create', compact('mailbox_protocols'));
        } catch (Exception $e) {
            // return error messages if any
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }


    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingMailboxSettingsUpdate($id, Request $request)
    {
        $updateresult = $this->updateExchange($id, $request, null);
        $return = $updateresult;
        return $return;
    }


    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingMailboxSettings(Request $request)
    {
        $this->storeExchange($request, null);
        $return = 1;
        return $return;
    }


    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingEmailSettings(Request $request)
    {
        $validator = \Validator::make(
            [
                'email_address' => $request->email_address,
                'email_name' => $request->email_name,
                'password' => $request->password,
            ], [
                'email_address' => 'required|email|unique:emails',
                'email_name' => 'required',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            $jsons = $validator->messages();
            $val = '';
            foreach ($jsons->all() as $key => $value) {
                $val .= $value;
            }
            $return_data = rtrim(str_replace('.', ',', $val), ',');
            return $return_data;
        }
        if ($request->validate == 'on') {
            $validate = '/validate-cert';
        } else {
            $validate = '/novalidate-cert';
        }
        if ($request->fetching_status == 'on') {
            $imap_check = $this->getImapStream($request, $validate);
            if ($imap_check[0] == 0) {
                return 'Incoming email connection failed';
            }
            $need_to_check_imap = 1;
        } else {
            $imap_check = 0;
            $need_to_check_imap = 0;
        }
        if ($request->sending_status == 'on') {
            $smtp_check = $this->getSmtp($request);
            if ($smtp_check == 0) {
                return 'Outgoing email connection failed';
            }
            $need_to_check_smtp = 1;
        } else {
            $smtp_check = 0;
            $need_to_check_smtp = 0;
        }
        if ($need_to_check_imap == 1 && $need_to_check_smtp == 1) {
            if ($imap_check != 0 && $smtp_check != 0) {
                $this->store($request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 1 && $need_to_check_smtp == 0) {
            if ($imap_check != 0 && $smtp_check == 0) {
                $this->store($request, $imap_check[1]);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 1) {
            if ($imap_check == 0 && $smtp_check != 0) {
                $this->store($request, null);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 0) {
            if ($imap_check == 0 && $smtp_check == 0) {
                $this->store($request, null);
                $return = 1;
            }
        }
        return $return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Emails        $email
     * @param type EmailsRequest $request
     *
     * @return type Redirect
     */
    public function storeExchange($request, $exchange_check = false)
    {
        //        dd($request);
        $mailbox = new Mailbox();

        try {
            //            getConnection($request->input('email_name'), $request->input('email_address'), $request->input('email_address'))
            // saving all the fields to the database
            //'department', 'priority', 'help_topic',
            //'fetching_encryption'
            //'sending_status'
            //'auto_response'
            $mailbox->fill($request->except('password', 'fetching_status', 'sending_status', 'department', 'priority', 'help_topic', 'auto_response'));

            if ($request->fetching_status == 'on') {
                $mailbox->fetching_status = 1;
            } else {
                $mailbox->fetching_status = 0;
            }

            $mailbox->mailbox_type = $request->input('fetching_protocol');

            //if ($request->sending_status == 'on') {
            //    $mailbox->sending_status = 1;
            //} else {
            $mailbox->sending_status = 0;
            //}
            //if ($request->auto_response == 'on') {
            //    $mailbox->auto_response = 1;
            //} else {
            $mailbox->auto_response = 0;
            //}

            // fetching department value
            $mailbox->department_id = 2;
            // fetching priority value
            $mailbox->priority_id = 4;
            // fetching helptopic value
            $mailbox->username = $request->input('email_address');

            $mailbox->helptopic_id = NULL;
            // inserting the encrypted value of password
            $mailbox->password = Crypt::encrypt($request->input('password'));

            try {
                $mailbox->save(); // run save
            } catch (Exception $e) {
                dd($e->getMessage());
            }

            // returns success message for successful email creation
            //                return redirect('emails')->with('success', 'Email Created sucessfully');

            // } else {
            //    dd("mailbox did not save");
            // returns fail message for unsuccessful save execution
            //                return redirect('emails')->with('fails', 'Email can not Create');
            //   return 0;
            //}
        } catch (Exception $e) {
            dd($e->getMessage());
            // returns if try fails
            //            return redirect()->back()->with('fails', $e->getMessage());
            return 0;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param type Emails        $email
     * @param type EmailsRequest $request
     *
     * @return type Redirect
     */
    public function store($request, $imap_check)
    {
        //        dd($request);
        $email = new Mailbox();
        try {
            //            getConnection($request->input('email_name'), $request->input('email_address'), $request->input('email_address'))
            // saving all the fields to the database
            if ($email->fill($request->except('password', 'department_id', 'priority_id', 'helptopic_id', 'fetching_status', 'fetching_encryption', 'sending_status', 'auto_response'))->save() == true) {
                if ($request->fetching_status == 'on') {
                    $email->fetching_status = 1;
                } else {
                    $email->fetching_status = 0;
                }
                if ($request->sending_status == 'on') {
                    $email->sending_status = 1;
                } else {
                    $email->sending_status = 0;
                }
                if ($request->auto_response == 'on') {
                    $email->auto_response = 1;
                } else {
                    $email->auto_response = 0;
                }
                if ($imap_check !== null) {
                    $email->fetching_encryption = $imap_check;
                } else {
                    $email->fetching_encryption = $request->fetching_encryption;
                }
                // fetching department value
                $email->department_id = 2;
                // fetching priority value
                $email->priority_id = 4;
                // fetching helptopic value
                $email->helptopic_id = NULL;
                // inserting the encrypted value of password
                $email->password = Crypt::encrypt($request->input('password'));
                $email->save(); // run save
                // Creating a default system email as the first email is inserted to the system
                $email_settings = Email::where('id', '=', '1')->first();
                $email_settings->sys_email = $email->id;
                $email_settings->save();
                // returns success message for successful email creation
                //                return redirect('emails')->with('success', 'Email Created sucessfully');
                return 1;
            } else {
                // returns fail message for unsuccessful save execution
                //                return redirect('emails')->with('fails', 'Email can not Create');
                return 0;
            }
        } catch (Exception $e) {
            // returns if try fails
            //            return redirect()->back()->with('fails', $e->getMessage());
            return 0;
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param type int             $id
     * @param type Department      $department
     * @param type Help_topic      $help
     * @param type Emails          $email
     * @param type Priority        $priority
     * @param type MailboxProtocol $mailbox_protocol
     *
     * @return type Response
     */
    public function edit($id, Mailbox $mailboxes, MailboxProtocol $mailbox_protocol)
    {
        try {
            // fetch the selected emails
            $mailbox = $mailboxes->whereId($id)->first();
            // get all the mailbox protocols
            $mailbox_protocols = $mailbox_protocol->get();
            // return if the execution is succeeded
            return view('email::mailboxes.edit', compact('mailbox_protocols', 'mailbox'));
        } catch (Exception $e) {
            // return if try fails
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }


    /**
     * Check for email input validation.
     *
     * @param EmailsRequest $request
     *
     * @return int
     */
    public function validatingEmailSettingsUpdate($id, Request $request)
    {
        //        return $request;
        if ($request->validate == 'on') {
            $validate = '/validate-cert';
        } else {
            $validate = '/novalidate-cert';
        }
        if ($request->fetching_status == 'on') {
            $imap_check = $this->getImapStream($request, $validate);
            if ($imap_check == 0) {
                return 'Incoming email connection failed';
            }
            $need_to_check_imap = 1;
        } else {
            $imap_check = 0;
            $need_to_check_imap = 0;
        }
        if ($request->sending_status == 'on') {
            $smtp_check = $this->getSmtp($request);
            if ($smtp_check == 0) {
                return 'Outgoing email connection failed';
            }
            $need_to_check_smtp = 1;
        } else {
            $smtp_check = 0;
            $need_to_check_smtp = 0;
        }


        if ($need_to_check_imap == 1 && $need_to_check_smtp == 1) {
            if ($imap_check != 0 && $smtp_check != 0) {
                $this->update($id, $request);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 1 && $need_to_check_smtp == 0) {
            if ($imap_check != 0 && $smtp_check == 0) {
                $this->update($id, $request);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 1) {
            if ($imap_check == 0 && $smtp_check != 0) {
                $this->update($id, $request);
                $return = 1;
            }
        } elseif ($need_to_check_imap == 0 && $need_to_check_smtp == 0) {
            if ($imap_check == 0 && $smtp_check == 0) {
                $this->update($id, $request);
                $return = 1;
            }
        }
        return $return;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param type Emails        $email
     * @param type EmailsRequest $request
     *
     * @return type Redirect
     */
    public function updateExchange($id, $request, $exchange_check = false)
    {
        $mailbox = Mailbox::whereId($id)->first();
        try {
            $mailbox->fill($request->except('password', 'department', 'priority', 'help_topic', 'fetching_status', 'sending_status'))->save();


            if ($request->fetching_status == 'on') {
                $mailbox->fetching_status = 1;
            } else {
                $mailbox->fetching_status = 0;
            }

            $mailbox->mailbox_type = $request->input('fetching_protocol');

            //if ($request->sending_status == 'on') {
            //    $mailbox->sending_status = 1;
            //} else {
            $mailbox->sending_status = 0;
            //}
            //if ($request->auto_response == 'on') {
            //    $mailbox->auto_response = 1;
            //} else {
            $mailbox->auto_response = 0;
            //}

            // fetching department value
            $mailbox->department_id = 2;
            // fetching priority value
            $mailbox->priority_id = 4;
            // fetching helptopic value
            $mailbox->username = $request->input('email_address');

            $mailbox->helptopic_id = NULL;
            // inserting the encrypted value of password
            $mailbox->password = Crypt::encrypt($request->input('password'));


            try {
                $mailbox->save(); // run save
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $return = 1;

        } catch (Exception $e) {
            dd($e->getMessage());
            // returns if try fails
            //            return redirect()->back()->with('fails', $e->getMessage());
            return 0;
        }
        return $return;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param type $id
     * @param type Emails            $email
     * @param type EmailsEditRequest $request
     *
     * @return type Response
     */
    public function update($id, $request)
    {
        try {
            // fetch the selected emails
            $emails = Emails::whereId($id)->first();
            // insert all the requested parameters with except
            $emails->fill($request->except('password', 'department', 'priority', 'help_topic', 'fetching_status', 'sending_status'))->save();
            if ($request->fetching_status == 'on') {
                $emails->fetching_status = 1;
            } else {
                $emails->fetching_status = 0;
            }
            if ($request->sending_status == 'on') {
                $emails->sending_status = 1;
            } else {
                $emails->sending_status = 0;
            }
            if ($request->auto_response == 'on') {
                $emails->auto_response = 1;
            } else {
                $emails->auto_response = 0;
            }
            // fetching department value
            $emails->department = $this->departmentValue($request->input('department'));
            // fetching priority value
            $emails->priority = $this->priorityValue($request->input('priority'));
            // fetching helptopic value
            $emails->help_topic = $this->helpTopicValue($request->input('help_topic'));
            // inserting the encrypted value of password
            $emails->password = Crypt::encrypt($request->input('password'));
            $emails->save();
            // returns success message for successful email update
            $return = 1;
        } catch (Exception $e) {
            // returns if try fails
            $return = $e->getMessage();
        }
        return $return;
    }


}