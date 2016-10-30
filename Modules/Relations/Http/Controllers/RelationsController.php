<?php
namespace Modules\Relations\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Datatables;
use Config;
use Dinero;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Settings;
use Modules\Relations\Requests\Relation\StoreRelationRequest;
use Modules\Relations\Requests\Relation\UpdateRelationRequest;
use Modules\Core\Services\User\UserServiceContract;
use Modules\Relations\Models\Relation;
use Modules\Core\Models\Staff;
use Modules\Core\Services\Setting\SettingServiceContract;

class RelationsController extends Controller
{

    protected $staff;
    protected $relations;
    protected $settings;

    public function __construct(
        Staff $staff,
        Relation $relations

    )
    {
        $this->users = $staff;
        $this->relations = $relations;

        //$this->middleware('relation.create', ['only' => ['create']]);
        //$this->middleware('relation.update', ['only' => ['edit']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //echo "guard staff (relations index)";
        //dd(Auth::guard('staff'));
        //dd(Auth::guard($guard));
        //dd(Auth::guard());
        return view('relations::relations.index');
    }

    public function anyData()
    {
        $relations = Relation::select(['id', 'name', 'shortname', 'relationtype_id'])->with('addresses');
/*        $relations = Relation::with(array('addresses'=>function($query){
            $query->addSelect(array('id','address', 'housenumber', 'postalcode', 'city_id', 'country_id'));
        }))->get('id', 'name', 'shortname', 'relationtype_id');*/

/*
// Example: We only want the title of the posts.
$authors = Author::with(array('posts' => function($query)
{
    // Notice the addition of the author_id field!
    $query->addSelect(array('title', 'author_id'));
}))->get();
 **/



        return Datatables::of($relations)
            ->addColumn('namelink', function ($relations) {
                return '<a href="relations/' . $relations->id . '" ">' . $relations->name . '</a>';
            })
            ->addColumn('websitelink', function ($relations) {
                return '<a href="relations/' . $relations->id . '" ">' . $relations->website . '</a>';
            })
            ->addColumn('phonelink', function ($relations) {
                return '<a href="relations/' . $relations->id . '" ">' . $relations->phone . '</a>';
            })

            ->add_column('edit', '
                <a href="{{ route(\'relations.edit\', $id) }}" class="btn btn-success" >Edit</a>')
            ->add_column('delete', '
                <form action="{{ route(\'relations.destroy\', $id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" name="submit" value="Delete" class="btn btn-danger" onClick="return confirm(\'Are you sure?\')"">

            {{csrf_field()}}
            </form>')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('relations.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withIndustries($this->relations->listAllIndustries());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreRelationRequest $request)
    {
        $this->relations->create($request->all());
        Session()->flash('flash_message', 'Relation successfully added');
        return redirect()->route('admin.relations.relations.index');
    }

    public function cvrapiStart(Request $vatRequest)
    {
        return redirect()->back()
            ->with('data', $this->relations->vat($vatRequest));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return view('relations.show')
            ->withRelation($this->relations->find($id))
            ->withCompanyname($this->settings->getCompanyName())
            ->withInvoices($this->relations->getInvoices($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('relations.edit')
            ->withRelation($this->relations->find($id))
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withIndustries($this->relations->listAllIndustries());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, UpdateRelationRequest $request)
    {
        $this->relations->update($id, $request);
        Session()->flash('flash_message', 'Relation successfully updated');
        return redirect()->route('admin.relations.relations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->relations->destroy($id);
        return redirect()->route('admin.relations.relations.index');
    }
}
