<?php

namespace Modules\Email\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// requests
use Modules\Core\Requests\CannedRequest;
use Modules\Core\Requests\CannedUpdateRequest;
// model
use Modules\Email\Models\Canned;
use Modules\Core\Models\Staff;
// classes
use Exception;

/**
 * CannedController.
 *
 * This controller is for all the functionalities of Canned response for Agents in the Agent Panel
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CannedController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking authentication
        //$this->middleware('auth');
        // checking if role is agent
        //$this->middleware('role.agent');
    }

    /**
     * Display a listing of the Canned Responses.
     *
     * @return type View
     */
    public function index()
    {
        return view('tickets::cannedreponses.index');
    }

    /**
     * Show the form for creating a new Canned Response.
     *
     * @return type View
     */
    public function create()
    {
        return view('tickets::cannedreponses.create');
    }

    /**
     * Store a newly created Canned Response.
     *
     * @param type CannedRequest $request
     * @param type Canned        $canned
     *
     * @return type Redirect
     */
    public function store(CannedRequest $request, Canned $canned)
    {
        // fetching all the requested inputs
        $canned->user_id = \Auth::guard('staff')->user()->id;
        $canned->title = $request->input('title');
        $canned->message = $request->input('message');
        try {
            // saving inputs
            $canned->save();

            return redirect()->route('canned.list')->with('success', 'Added Successfully');
        } catch (Exception $e) {
            return redirect()->route('canned.list')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Show the form for editing the Canned Response.
     *
     * @param type        $id
     * @param type Canned $canned
     *
     * @return type View
     */
    public function edit($id, Canned $canned)
    {
        // fetching requested canned response
        $canned = $canned->where('user_id', '=', \Auth::guard('staff')->user()->id)->where('id', '=', $id)->first();

        return view('tickets::cannedreponses.edit', compact('canned'));
    }

    /**
     * Update the Canned Response in database.
     *
     * @param type                     $id
     * @param type CannedUpdateRequest $request
     * @param type Canned              $canned
     *
     * @return type Redirect
     */
    public function update($id, CannedUpdateRequest $request, Canned $canned)
    {
        /* select the field where id = $id(request Id) */
        $canned = $canned->where('id', '=', $id)->where('user_id', '=', \Auth::guard('staff')->user()->id)->first();
        // fetching all the requested inputs
        $canned->user_id = \Auth::guard('staff')->user()->id;
        $canned->title = $request->input('title');
        $canned->message = $request->input('message');
        try {
            // saving inputs
            $canned->save();

            return redirect()->route('canned.list')->with('success', 'Updated Successfully');
        } catch (Exception $e) {
            return redirect()->route('canned.list')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Delete the Canned Response from storage.
     *
     * @param type        $id
     * @param type Canned $canned
     *
     * @return type Redirect
     */
    public function destroy($id, Canned $canned)
    {
        /* select the field where id = $id(request Id) */
        $canned = $canned->whereId($id)->first();
        /* delete the selected field */
        /* Check whether function success or not */
        try {
            $canned->delete();
            /* redirect to Index page with Success Message */
            return redirect()->route('canned.list')->with('success', 'User  Deleted Successfully');
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect()->route('canned.list')->with('fails', $e->errorInfo[2]);
        }
    }

    /**
     * Fetch Canned Response in the ticket detail page.
     *
     * @param type $id
     *
     * @return type json
     */
    public function get_canned($id)
    {
        // checking for the canned response with requested value
        if ($id != 'zzz') {
            // fetching canned response
            $canned = Canned::where('id', '=', $id)->where('user_id', '=', \Auth::guard('staff')->user()->id)->first();
            $msg = $canned->message;
        } else {
            $msg = '';
        }
        // returning the canned response in JSON format
        return \Response::json($msg);
    }
}
