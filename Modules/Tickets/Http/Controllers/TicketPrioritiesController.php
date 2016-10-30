<?php

namespace Modules\Tickets\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Tickets\Models\TicketType;
use Modules\Tickets\Models\TicketStatus;
use Modules\Tickets\Models\TicketPriority;
use Modules\Tickets\Models\Ticket;
use Modules\Core\Models\Staff;
use Modules\Core\Models\User;
use Gate;
use Modules\Tickets\Models\TicketTime;
use Datatables;
use Carbon;

class TicketPrioritiesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('ticket.create', ['only' => ['create']]);
        //$this->middleware('ticket.update.status', ['only' => ['updateStatus']]);
        //$this->middleware('ticket.assigned', ['only' => ['updateAssign', 'updateTime']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets::ticketpriorities.index');
    }

    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $ticketpriorities = TicketPriority::select(['id', 'priority', 'priority_desc', 'priority_color', 'priority_urgency', 'ispublic']);
        return Datatables::of($ticketpriorities)

            ->addColumn('ticketpriolink', function ($ticketpriorities) {
                return '<a href="ticketspanel/ticketpriorities/' . $ticketpriorities->id . '" ">' . $ticketpriorities->priority . '</a>';
            })
            ->addColumn('ticketpriocolor', function ($ticketpriorities) {
                return '<a href="ticketspanel/ticketpriorities/' . $ticketpriorities->id . '" ">' . $ticketpriorities->priority_color . '</a>';
            })

            ->addColumn('actions', function ($ticketpriorities) {
                return '
                <form action="' . route('ticketpriorities.destroy', [$ticketpriorities->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('ticketpriorities.edit', [$ticketpriorities->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
