<?php

namespace Modules\Core\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;


// requests
use Modules\Core\Requests\TeamRequest;
use Modules\Core\Requests\TeamUpdate;
// models
use Modules\Core\Models\AssignTeamStaff;
use Modules\Core\Models\Team;
use Modules\Core\Models\Staff;
// classes
use DB;
use Exception;

/**
 * TeamController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class TeamsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type void
     */
    public function __construct()
    {

        $page_title = trans('core::admin/teams/general.page.index.title'); // "Admin | Staff";
        $page_description = trans('core::admin/teams/general.page.index.description'); // "List of staff";
        //$this->middleware('auth');
        //$this->middleware('roles');
    }

    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $teams = Team::select(['id', 'name', 'status', 'team_lead', 'assign_alert', 'admin_notes']);
        return Datatables::of($teams)

            ->addColumn('teamnamelink', function ($teams) {
                return '<a href="adminpanel/teams/' . $teams->id . '" ">' . $teams->name . '</a>';
            })
            ->addColumn('teamsstatuslink', function ($teams) {
                return $teams->status;
            })
            ->addColumn('teamleadlink', function ($teams) {
                return $teams->team_lead;
            })

            ->addColumn('actions', function ($teams) {
                return '
                <form action="' . route('admin.teams.destroy', [$teams->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('admin.teams.edit', [$teams->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }




    public function index()
    {
        return view('core::admin.teams.index');
    }







    /**
     * get Index page.
     *
     * @param type Teams             $team
     * @param type Assign_team_agent $assign_team_staff
     *
     * @return type Response
     */
    public function oldindex(Teams $team, AssignTeamStaff $assign_team_staff)
    {
        $teams = $team->get();

        /*  find out the Number of Members in the Team */
        //$id = $teams->lists('id');
        $assign_team_staff = $assign_team_staff->get();

    return view('core::teams.index', compact('teams', 'assign_team_staff'));



    /*try {
        $teams = $team->get();
        /*  find out the Number of Members in the Team *    /
        $id = $teams->lists('id');
        $assign_team_staff = $assign_team_staff->get();

        return view('core::teams.index', compact('assign_team_staff', 'teams'));
    } catch (Exception $e) {
        return redirect()->back()->with('fails', $e->errorInfo[2]);
    }*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param type User $user
     *
     * @return type Response
     */
    public function create(User $user)
    {
        try {
            $user = $user->get();

            return view('core::staff.teams.create', compact('user'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param type Teams       $team
     * @param type TeamRequest $request
     *
     * @return type Response
     */
    public function store(Teams $team, TeamRequest $request)
    {
        if ($request->team_lead) {
            $team_lead = $request->team_lead;
        } else {
            $team_lead = null;
        }
        $team->team_lead = $team_lead;
        try {
            /* Check whether function success or not */
            $team->fill($request->except('team_lead'))->save();
            /* redirect to Index page with Success Message */
            return redirect('teams')->with('success', 'Teams  Created Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('teams')->with('fails', 'Teams can not Create'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param type                   $id
     * @param type User              $user
     * @param type Assign_team_agent $assign_team_staff
     * @param type Teams             $team
     *
     * @return type Response
     */
    public function edit($id, User $user, Assign_team_agent $assign_team_staff, Teams $team)
    {
        try {
            $user = $user->whereId($id)->first();
            $teams = $team->whereId($id)->first();
            $agent_team = $assign_team_staff->where('team_id', $id)->get();
            $agent_id = $agent_team->lists('agent_id', 'agent_id');

            return view('core::staff.teams.edit', compact('agent_id', 'user', 'teams', 'allagents'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int        $id
     * @param type Teams      $team
     * @param type TeamUpdate $request
     *
     * @return type Response
     */
    public function update($id, Teams $team, TeamUpdate $request)
    {
        $teams = $team->whereId($id)->first();
        //updating check box
        if ($request->team_lead) {
            $team_lead = $request->team_lead;
        } else {
            $team_lead = null;
        }
        $teams->team_lead = $team_lead;
        $teams->save();

        $alert = $request->input('assign_alert');
        $teams->assign_alert = $alert;
        $teams->save(); //saving check box
        //updating whole field
        /* Check whether function success or not */
        try {
            $teams->fill($request->except('team_lead'))->save();
            /* redirect to Index page with Success Message */
            return redirect('teams')->with('success', 'Teams  Updated Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('teams')->with('fails', 'Teams  can not Update'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param type int               $id
     * @param type Teams             $team
     * @param type Assign_team_agent $assign_team_staff
     *
     * @return type Response
     */
    public function destroy($id, Teams $team, Assign_team_agent $assign_team_staff)
    {
        try {
            $assign_team_staff->where('team_id', $id)->delete();
            $teams = $team->whereId($id)->first();
            $tickets = DB::table('tickets')->where('team_id', '=', $id)->update(['team_id' => null]);
            /* Check whether function success or not */
            $teams->delete();
            /* redirect to Index page with Success Message */
            return redirect('teams')->with('success', 'Teams  Deleted Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('teams')->with('fails', 'Teams can not Delete'.'<li>'.$e->errorInfo[2].'</li>');
        }
    }
}
