<?php

namespace Modules\Tickets\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// requests
use Modules\Core\Requests\SlaRequest;
use Modules\Core\Requests\SlaUpdate;
// models
use Modules\Tickets\Models\SlaPlan;
use Modules\Core\Models\Settings\Ticket;
//classes
use Illuminate\Http\Request;
use Gate;
use DB;
use Exception;
use Datatables;
use Carbon;





/**
 * SlaController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class SlaPlansController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @param type SlaPlan $sla
     *
     * @return type Response
     */
    public function index(SlaPlan $sla)
    {
        //try {
            /* Declare a Variable $slas to store all Values From SlaPlan Table */
            //$slas = $sla->get();
            /* Listing the values From SlaPlan Table */
            //compact('slas')
            return view('tickets::slaplans.index');
        //} catch (Exception $e) {
        //    return redirect()->back()->with('fails', $e->errorInfo[2]);
        //}
    }

    public function anyData()
    {
/*
{data: 'slaplanname', name: 'ticket_number'},
{data: 'slaplanstatus', name: 'subject'},
{data: 'grace_period', name: 'grace_period'},
{data: 'created_at', name: 'created_at'},
{data: 'last_updated', name: 'updated_at'},
{data: 'action', name: 'assigned_to'},
 **/


        $slaplans = SlaPlan::select([
            'id', 'name', 'grace_period', 'admin_note', 'status', 'transient', 'ticket_overdue'
        ])->orderBy('ticket_overdue', 'desc');
        return Datatables::of($slaplans)
            ->addColumn('slaplanname', function ($slaplans) {
                return '<a href="/ticketspanel/slaplans/' . $slaplans->id . '" ">' . $slaplans->name . '</a>';
            })
            ->addColumn('slaplanstatus', function ($slaplans) {
                return '<a href="/ticketspanel/slaplans/' . $slaplans->id . '" ">' . $slaplans->status . '</a>';
            })
            ->addColumn('grace_period', function ($slaplans) {
                return '<a href="/ticketspanel/slaplans/' . $slaplans->id . '" ">' . $slaplans->grace_period . '</a>';
            })
            ->addColumn('actions', function ($slaplans) {
                return '
                <form action="' . route('slaplans.destroy', [$slaplans->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('slaplans.edit', [$slaplans->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })

            ->make(true);
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return type Response
     */
    public function create()
    {
        try {
            /* Direct to Create Page */
            return view('core::manage.sla.create');
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type SlaPlan   $sla
     * @param type SlaRequest $request
     *
     * @return type Response
     */
    public function store(SlaPlan $sla, SlaRequest $request)
    {
        try {
            /* Fill the request values to SlaPlan Table  */
            /* Check whether function success or not */
            $sla->fill($request->input())->save();
            /* redirect to Index page with Success Message */
            return redirect('sla')->with('success', 'SLA Plan Created Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('sla')->with('fails', 'SLA Plan can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type int      $id
     * @param type SlaPlan $sla
     *
     * @return type Response
     */
    public function edit($id, SlaPlan $sla)
    {
        try {
            /* Direct to edit page along values of perticular field using Id */
            $slas = $sla->whereId($id)->first();
            $slas->get();

            return view('core::manage.sla.edit', compact('slas'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int       $id
     * @param type SlaPlan  $sla
     * @param type SlaUpdate $request
     *
     * @return type Response
     */
    public function update($id, SlaPlan $sla, SlaUpdate $request)
    {
        try {
            /* Fill values to selected field using Id except Check box */
            $slas = $sla->whereId($id)->first();
            $slas->fill($request->except('transient', 'ticket_overdue'))->save();
            /* Update transient checkox field */
            $slas->transient = $request->input('transient');
            /* Update ticket_overdue checkox field */
            $slas->ticket_overdue = $request->input('ticket_overdue');
            /* Check whether function success or not */
            $slas->save();
            /* redirect to Index page with Success Message */
            return redirect('sla')->with('success', 'SLA Plan Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('sla')->with('fails', 'SLA Plan can not Update'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int      $id
     * @param type SlaPlan $sla
     *
     * @return type Response
     */
    public function destroy($id, SlaPlan $sla)
    {
        $default_sla = Ticket::where('id', '=', '1')->first();
        if ($default_sla->sla == $id) {
            return redirect('departments')->with('fails', 'You cannot delete default department');
        } else {
            $tickets = DB::table('tickets')->where('sla', '=', $id)->update(['sla' => $default_sla->sla]);
            if ($tickets > 0) {
                if ($tickets > 1) {
                    $text_tickets = 'Tickets';
                } else {
                    $text_tickets = 'Ticket';
                }
                $ticket = '<li>'.$tickets.' '.$text_tickets.' have been moved to default SLA</li>';
            } else {
                $ticket = '';
            }
            $dept = DB::table('department')->where('sla', '=', $id)->update(['sla' => $default_sla->sla]);
            if ($dept > 0) {
                if ($dept > 1) {
                    $text_dept = 'Emails';
                } else {
                    $text_dept = 'Email';
                }
                $dept = '<li>Associated department have been moved to default SLA</li>';
            } else {
                $dept = '';
            }
            $topic = DB::table('help_topic')->where('sla_plan', '=', $id)->update(['sla_plan' => $default_sla->sla]);
            if ($topic > 0) {
                if ($topic > 1) {
                    $text_topic = 'Emails';
                } else {
                    $text_topic = 'Email';
                }
                $topic = '<li>Associated Help Topic have been moved to default SLA</li>';
            } else {
                $topic = '';
            }
            $message = $ticket.$dept.$topic;
            /* Delete a perticular field from the database by delete() using Id */
            $slas = $sla->whereId($id)->first();
            /* Check whether function success or not */
            try {
                $slas->delete();
                /* redirect to Index page with Success Message */
                return redirect('sla')->with('success', 'SLA Plan Deleted Successfully'.$message);
            } catch (Exception $e) {
                /* redirect to Index page with Fails Message */
                return redirect('sla')->with('fails', 'SLA Plan can not Delete'.'<li>'.$e->errorInfo[2].'</li>');
            }
        }
    }
}
