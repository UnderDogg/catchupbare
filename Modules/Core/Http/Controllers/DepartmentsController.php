<?php
namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;


use Illuminate\Http\Request;
use App\Http\Requests;

use Modules\Core\Models\Department;
use Session;
use Modules\Core\Requests\Department\StoreDepartmentRequest;

class DepartmentsController extends Controller
{

    protected $departments;

    public function __construct(Department $departments)
    {
        $page_title = trans('core::admin/departments/general.page.index.title'); // "Admin | Staff";
        $page_description = trans('core::admin/departments/general.page.index.description'); // "List of staff";

        //$departments = $this->staff->pushCriteria(new StaffWithRoles())->pushCriteria(new StaffByUsernamesAscending())->paginate(10);
        //return view('core::admin.departments.index', compact('departments', 'page_title', 'page_description'));
    }





    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $departments = Department::select(['id', 'name', 'departmenttype', 'isdefault', 'slaplan_id', 'manager_id']);
        return Datatables::of($departments)

            ->addColumn('departmentsnamelink', function ($departments) {
                return '<a href="adminpanel/departments/' . $departments->id . '" ">' . $departments->name . '</a>';
            })
            ->addColumn('departmentstypelink', function ($departments) {
                return '<a href="adminpanel/departments/' . $departments->id . '" ">' . $departments->departmenttype . '</a>';
            })

            ->addColumn('slaplanlink', function ($departments) {
                return $departments->slaplan_id;
            })
            ->addColumn('departmentmanagerlink', function ($departments) {
                return $departments->manager_id;
            })

            ->addColumn('actions', function ($departments) {
                return '
                <form action="' . route('admin.departments.destroy', [$departments->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('admin.departments.edit', [$departments->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }




    public function index()
    {
        return view('core::admin.departments.index');
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->departments->create($request);
        Session::flash('flash_message', 'Successfully created New Department');
        return redirect()->route('departments.index');
    }

    public function destroy($id)
    {
        $this->departments->destroy($id);
        return redirect()->route('departments.index');
    }
}
