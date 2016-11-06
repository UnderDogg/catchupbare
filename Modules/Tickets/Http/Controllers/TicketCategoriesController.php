<?php
namespace Modules\Tickets\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// models
use Modules\Core\Models\Staff;
use Modules\Core\Models\Department;
use Modules\Core\Models\Team;
use Modules\Core\Models\Form\Forms;
use Modules\Tickets\Models\Ticket;

use Modules\Tickets\Models\SlaPlan;

use Modules\Core\Models\User;
use Modules\Relations\Models\Relation;

use Modules\Tickets\Models\TicketAttachment;
use Modules\Tickets\Models\TicketCategory;
use Modules\Tickets\Models\TicketCollaborator;
use Modules\Tickets\Models\TicketHelpTopic;
use Modules\Tickets\Models\TicketPriority;
use Modules\Tickets\Models\TicketSource;
use Modules\Tickets\Models\TicketStatus;
use Modules\Tickets\Models\TicketThread;
use Modules\Tickets\Models\TicketTime;
use Modules\Tickets\Models\TicketType;
//classes
use Illuminate\Http\Request;
use DB;
use Exception;
use Datatables;
use Carbon;

/**
 * HelptopicController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TicketCategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type vodi
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(TicketCategory $ticketcategory)
    {
        //try {
            return view('tickets::ticketcategories.index');
        //} catch (Exception $e) {
        //    return view('errors.404');
        //}
    }


    public function anyData()
    {
        $ticketcategories = TicketCategory::select([
            'id', 'name'
        ]);
        return Datatables::of($ticketcategories)
            ->addColumn('ticketcatlink', function ($ticketcategories) {
                return '<a href="ticketspanel/categories/' . $ticketcategories->id . '" ">' . $ticketcategories->name . '</a>';
            })

            ->addColumn('actions', function ($ticketcategories) {
                return '
                <form action="' . route('ticketcategories.destroy', [$ticketcategories->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('ticketcategories.edit', [$ticketcategories->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @param type Priority   $priority
     * @param type Department $department
     * @param type Help_topic $topic
     * @param type Form_name  $form
     * @param type Agents     $agent
     * @param type Sla_plan   $sla
     *
     * @return type Response
     */
    /*
      ================================================
      | Route to Create view file passing Model Values
      | 1.Department Model
      | 2.Help_topic Model
      | 3.Agents Model
      | 4.Sla_plan Model
      | 5.Forms Model
      ================================================
     */
    public function create(TicketPriority $priority, Department $department, Help_topic $topic, Forms $form, User $agent, Sla_plan $sla)
    {
        try {
            $departments = $department->get();
            $topics = $topic->get();
            $forms = $form->get();
            $agents = $agent->where('role', '=', 'agent')->get();
            $slas = $sla->get();
            $priority = $priority->get();

            return view('core::manage.helptopic.create', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas'));
        } catch (Exception $e) {
            return view('errors.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Help_topic       $topic
     * @param type HelptopicRequest $request
     *
     * @return type Response
     */
    public function store(Help_topic $topic, HelptopicRequest $request)
    {
        try {
            if ($request->custom_form) {
                $custom_form = $request->custom_form;
            } else {
                $custom_form = null;
            }
            if ($request->auto_assign) {
                $auto_assign = $request->auto_assign;
            } else {
                $auto_assign = null;
            }
            /* Check whether function success or not */
            $topic->fill($request->except('custom_form', 'auto_assign'))->save();
            // $topics->fill($request->except('custom_form','auto_assign'))->save();
            /* redirect to Index page with Success Message */
            return redirect('helptopic')->with('success', 'Helptopic Created Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('helptopic')->with('fails', 'Helptopic can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type            $id
     * @param type Priority   $priority
     * @param type Department $department
     * @param type Help_topic $topic
     * @param type Form_name  $form
     * @param type Agents     $agent
     * @param type Sla_plan   $sla
     *
     * @return type Response
     */
    public function edit($id, Ticket_Priority $priority, Department $department, Help_topic $topic, Forms $form, Sla_plan $sla)
    {
        try {
            $agents = User::where('role', '=', 'agent')->get();
            $departments = $department->get();
            $topics = $topic->whereId($id)->first();
            $forms = $form->get();
            $slas = $sla->get();
            $priority = $priority->get();

            return view('core::manage.helptopic.edit', compact('priority', 'departments', 'topics', 'forms', 'agents', 'slas'));
        } catch (Exception $e) {
            return redirect('helptopic')->with('fails', '<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type                 $id
     * @param type Help_topic      $topic
     * @param type HelptopicUpdate $request
     *
     * @return type Response
     */
    public function update($id, Help_topic $topic, HelptopicUpdate $request)
    {
        // dd($request);
        try {
            $topics = $topic->whereId($id)->first();
            if ($request->custom_form) {
                $custom_form = $request->custom_form;
            } else {
                $custom_form = null;
            }
            if ($request->auto_assign) {
                $auto_assign = $request->auto_assign;
            } else {
                $auto_assign = null;
            }
            /* Check whether function success or not */
            $topics->fill($request->except('custom_form', 'auto_assign'))->save();
            $topics->custom_form = $custom_form;
            $topics->auto_assign = $auto_assign;
            $topics->save();
            /* redirect to Index page with Success Message */
            return redirect('helptopic')->with('success', 'Helptopic Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('helptopic')->with('fails', 'Helptopic can not Update'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int        $id
     * @param type Help_topic $topic
     *
     * @return type Response
     */
    public function destroy($id, Help_topic $topic, Ticket $ticket_setting)
    {
        $ticket_settings = $ticket_setting->where('id', '=', '1')->first();
        if ($ticket_settings->help_topic == $id) {
            return redirect('departments')->with('fails', 'You cannot delete default department');
        } else {
            $tickets = DB::table('tickets')->where('help_topic_id', '=', $id)->update(['help_topic_id' => $ticket_settings->help_topic]);

            if ($tickets > 0) {
                if ($tickets > 1) {
                    $text_tickets = 'Tickets';
                } else {
                    $text_tickets = 'Ticket';
                }
                $ticket = '<li>'.$tickets.' '.$text_tickets.' have been moved to default Help Topic</li>';
            } else {
                $ticket = '';
            }

            $emails = DB::table('emails')->where('help_topic', '=', $id)->update(['help_topic' => $ticket_settings->help_topic]);

            if ($emails > 0) {
                if ($emails > 1) {
                    $text_emails = 'Emails';
                } else {
                    $text_emails = 'Email';
                }
                $email = '<li>'.$emails.' System '.$text_emails.' have been moved to default Help Topic</li>';
            } else {
                $email = '';
            }

            $message = $ticket.$email;

            $topics = $topic->whereId($id)->first();
            /* Check whether function success or not */
            try {
                $topics->delete();
                /* redirect to Index page with Success Message */
                return redirect('helptopic')->with('success', 'Helptopic Deleted Successfully'.$message);
            } catch (Exception $e) {
                /* redirect to Index page with Fails Message */
                return redirect('helptopic')->with('fails', 'Helptopic can not Delete'.'<li>'.$e->errorInfo[2].'</li>');
            }
        }
    }
}
