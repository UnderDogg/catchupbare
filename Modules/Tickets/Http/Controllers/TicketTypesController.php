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



class TicketTypesController extends Controller
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
        return view('tickets::tickettypes.index');
    }

    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $tickettypes = TicketType::select(['id', 'ispublic', 'name', 'displayicon', 'departmentid', 'ismaster', 'displayorder']);
        return Datatables::of($tickettypes)

            ->addColumn('tickettypelink', function ($tickettypes) {
                return '<a href="ticketspanel/tickettypes/' . $tickettypes->id . '" ">' . $tickettypes->name . '</a>';
            })
            ->addColumn('tickettypedepartment', function ($tickettypes) {
                return '<a href="ticketspanel/tickettypes/' . $tickettypes->id . '" ">' . $tickettypes->departmentid . '</a>';
            })

            ->addColumn('actions', function ($tickettypes) {
                return '
                <form action="' . route('tickettypes.destroy', [$tickettypes->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('tickettypes.edit', [$tickettypes->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
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
