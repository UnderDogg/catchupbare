<?php
namespace Modules\Leads\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Leads\Models\Lead;
use Modules\Core\Models\User;
use Modules\Core\Models\Staff;
use Modules\Relations\Models\Relation;
use App\Http\Requests;
use Session;
use App\Http\Controllers\Controller;
use Modules\Models\Settings;
use Auth;
use Datatables;
use Carbon;
use Modules\Core\Models\Activity;
use DB;
use Modules\Leads\Requests\Lead\StoreLeadRequest;
use Modules\Leads\Requests\Lead\UpdateLeadFollowUpRequest;
use Modules\Leads\Services\Lead\LeadServiceContract;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Relations\Services\Relation\RelationServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;

class LeadsController extends Controller
{
    protected $leads;
    protected $relations;
    protected $settings;
    protected $users;

    public function __construct(
        LeadServiceContract $leads,
        UserServiceContract $users,
        RelationServiceContract $relations,
        SettingServiceContract $settings
    )
    {
        $this->users = $users;
        $this->settings = $settings;
        $this->relations = $relations;
        $this->leads = $leads;
        //$this->middleware('staff');
        $this->middleware('lead.create', ['only' => ['create']]);
        $this->middleware('lead.assigned', ['only' => ['updateAssign']]);
        $this->middleware('lead.update.status', ['only' => ['updateStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leads.index');
    }

    public function anyData()
    {
        $leads = Lead::select(
            ['id', 'title', 'fk_staff_id_created', 'fk_relation_id', 'assigned_to_staff_id', 'contact_date']
        )->where('status_id', 1)->get();
        return Datatables::of($leads)
            ->addColumn('titlelink', function ($leads) {
                return '<a href="leads/' . $leads->id . '" ">' . $leads->title . '</a>';
            })
            ->editColumn('fk_staff_id_created', function ($leads) {
                return $leads->createdBy->name;
            })
            ->editColumn('contact_date', function ($leads) {
                return $leads->contact_date ? with(new Carbon($leads->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('assigned_to_staff_id', function ($leads) {
                return $leads->assignee->name;
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leads.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withRelations($this->relations->listAllRelations());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeadRequest $request)
    {
        $getInsertedId = $this->leads->create($request);
        Session()->flash('flash_message', 'Lead is created');
        return redirect()->route('leads.show', $getInsertedId);
    }

    public function updateAssign($id, Request $request)
    {
        $this->leads->updateAssign($id, $request);
        Session()->flash('flash_message', 'New user is assigned');
        return redirect()->back();
    }

    public function updateFollowup(UpdateLeadFollowUpRequest $request, $id)
    {
        $this->leads->updateFollowup($id, $request);
        Session()->flash('flash_message', 'New follow up date is set');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('leads.show')
            ->withLeads($this->leads->find($id))
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withCompanyname($this->settings->getCompanyName());
    }

    public function updateStatus($id, Request $request)
    {
        $this->leads->updateStatus($id, $request);
        Session()->flash('flash_message', 'Lead is completed');
        return redirect()->back();
    }
}
