<?php
namespace App\Http\Controllers\Client\helpdesk;

// controllers
use Modules\Tickets\Http\Controllers\TicketWorkflowController;
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
use Modules\Core\Requests\ClientRequest;
use Modules\Core\Models\Department;
// models
use Modules\Helpdesk\Models\Form\Fields;
use Modules\Helpdesk\Models\Help_topic;
use Modules\Core\Models\Settings\System;
use Modules\Tickets\Models\Settings\Ticket as TicketSettings;
use Modules\Tickets\Models\Ticket_Attachments;
use Modules\Tickets\Models\Ticket_Source;
use Modules\Tickets\Models\Ticket_Thread;
use Modules\Tickets\Models\Ticket;
use Modules\Core\Models\Staff;
use Exception;
// classes
use Form;
use Illuminate\Http\Request;
use Input;
use Mail;
use Redirect;

/**
 * FormController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class FormController extends Controller
{
    /**
     * Create a new controller instance.
     * Constructor to check.
     *
     * @return void
     */
    public function __construct()
    {
        // mail smtp settings
        //        SettingsController::smtp();
        // creating a TicketController instance
        //$this->TicketWorkflowController = $TicketWorkflowController;
    }

    /**
     * getform.
     *
     * @param type Help_topic $topic
     *
     * @return type
     */
    public function getForm(Help_topic $topic)
    {
        $topics = null;
        return view('themes.default1.client.helpdesk.form', compact('topics'));

        /*    if (System::first()->status == 1) {
          $topics = $topic->get();
          return view('themes.default1.client.helpdesk.form', compact('topics'));
        } else {
          return \Redirect::route('home');
        }*/
    }

    /**
     * This Function to post the form for the ticket.
     *
     * @param type Form_name    $name
     * @param type Form_details $details
     *
     * @return type string
     */
    public function postForm($id, Help_topic $topic)
    {
        // dd($id);
        if ($id != 0) {
            $helptopic = $topic->where('id', '=', $id)->first();
            $custom_form = $helptopic->custom_form;
            $values = Fields::where('forms_id', '=', $custom_form)->get();
            if (!$values) {
            }
            if ($values) {
                foreach ($values as $value) {
                    if ($value->type == 'select') {
                        $data = $value->value;
                        $value = explode(',', $data);
                        echo '<select class="form-control">';
                        foreach ($value as $option) {
                            echo '<option>' . $option . '</option>';
                        }
                        echo '</select></br>';
                    } elseif ($value->type == 'radio') {
                        $type2 = $value->value;
                        $val = explode(',', $type2);
                        echo '<label class="radio-inline">' . $value->label . '</label>&nbsp&nbsp&nbsp<input type="' . $value->type . '" name="' . $value->name . '">&nbsp;&nbsp;' . $val[0] . '
		            	&nbsp&nbsp&nbsp<input type="' . $value->type . '" name="' . $value->name . '">&nbsp;&nbsp;' . $val[1] . '</br>';
                    } elseif ($value->type == 'textarea') {
                        $type3 = $value->value;
                        $v = explode(',', $type3);
                        //dd($v);
                        if (array_key_exists(1, $v)) {
                            echo '<label>' . $value->label . '</label></br><textarea class=form-control rows="' . $v[0] . '" cols="' . $v[1] . '"></textarea></br>';
                        } else {
                            echo '<label>' . $value->label . '</label></br><textarea class=form-control rows="10" cols="60"></textarea></br>';
                        }
                    } elseif ($value->type == 'checkbox') {
                        $type4 = $value->value;
                        $check = explode(',', $type4);
                        echo '<label class="radio-inline">' . $value->label . '&nbsp&nbsp&nbsp<input type="' . $value->type . '" name="' . $value->name . '">&nbsp&nbsp' . $check[0] . '</label><label class="radio-inline"><input type="' . $value->type . '" name="' . $value->name . '">&nbsp&nbsp' . $check[1] . '</label></br>';
                    } else {
                        echo '<label>' . $value->label . '</label><input type="' . $value->type . '" class="form-control"   name="' . $value->name . '" /></br>';
                    }
                }
            }
        } else {
            return;
        }
    }

    /**
     * Posted form.
     *
     * @param type Request $request
     * @param type User    $user
     */
    public function postedForm(User $user, ClientRequest $request, Ticket $ticket_settings, Ticket_source $ticket_source, Ticket_attachments $ta)
    {
        $form_extras = $request->except('Name', 'Phone', 'Email', 'Subject', 'Details', 'helptopic', '_wysihtml5_mode', '_token');
        $name = $request->input('Name');
        $phone = $request->input('Phone');
        $email = $request->input('Email');
        $subject = $request->input('Subject');
        $details = $request->input('Details');
        $System = System::where('id', '=', 1)->first();
        $departments = Department::where('id', '=', $System->department)->first();
        $department = $departments->id;
        $status = $ticket_settings->first()->status;
        $helptopic = $ticket_settings->first()->help_topic;
        $sla = $ticket_settings->first()->sla;
        $priority = $ticket_settings->first()->priority;
        $source = $ticket_source->where('name', '=', 'web')->first()->id;
        $attachments = $request->file('attachment');
        $collaborator = null;
        $assignto = null;
        $auto_response = 0;
        $team_assign = null;
        $result = $this->TicketWorkflowController->workflow($email, $name, $subject, $details, $phone, $helptopic, $sla, $priority, $source, $collaborator, $department, $assignto, $team_assign, $status, $form_extras, $auto_response);
        if ($result[1] == 1) {
            $ticketId = Tickets::where('ticket_number', '=', $result[0])->first();
            $thread = Ticket_Thread::where('ticket_id', '=', $ticketId->id)->first();
            if ($attachments != null) {
                foreach ($attachments as $attachment) {
                    if ($attachment != null) {
                        $name = $attachment->getClientOriginalName();
                        $type = $attachment->getClientOriginalExtension();
                        $size = $attachment->getSize();
                        $data = file_get_contents($attachment->getRealPath());
                        $attachPath = $attachment->getRealPath();
                        $ta->create(['thread_id' => $thread->id, 'name' => $name, 'size' => $size, 'type' => $type, 'file' => $data, 'poster' => 'ATTACHMENT']);
                    }
                }
            }
            return Redirect::route('guest.getform')->with('success', 'Ticket has been created successfully, your ticket number is <b>' . $result[0] . '</b> Please save this for future reference.');
        }
    }

    /**
     * reply.
     *
     * @param type $value
     *
     * @return type view
     */
    public function post_ticket_reply($id, Request $request)
    {
        $comment = $request->input('comment');
        if ($comment != null) {
            $tickets = Tickets::where('id', '=', $id)->first();
            $threads = new Ticket_Thread();
            $tickets->closed_at = null;
            $tickets->closed = 0;
            $tickets->reopened_at = date('Y-m-d H:i:s');
            $tickets->reopened = 1;
            $threads->user_id = $tickets->user_id;
            $threads->ticket_id = $tickets->id;
            $threads->poster = 'client';
            $threads->body = $comment;
            try {
                $threads->save();
                $tickets->save();
                return \Redirect::back()->with('success1', 'Successfully replied');
            } catch (Exception $e) {
                return \Redirect::back()->with('fails1', $e->errorInfo[2]);
            }
        } else {
            return \Redirect::back()->with('fails1', 'Please fill some data!');
        }
    }
}
