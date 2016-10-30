<?php
namespace Modules\Employees\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Employees\Models\Employee;
use Modules\Tickets\Models\Ticket;
use Illuminate\Http\Request;
use Gate;
use Datatables;
use Carbon;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Support\Facades\Input;
use Modules\Models\Relation;
use Modules\Models\Staff;
use Modules\Employees\Http\Requests\Staff\StoreStaffRequest;
use Modules\Employees\Http\Requests\Staff\UpdateStaffRequest;
use Modules\Employees\Services\Staff\StaffServiceContract;
use Modules\Core\Services\Role\RoleServiceContract;
use Modules\Core\Services\Department\DepartmentServiceContract;
use Modules\Core\Services\Setting\SettingServiceContract;

class EmployeesController extends Controller
{
    protected $employees;
    protected $roles;
    protected $departments;
    protected $settings;

    public function __construct(
        StaffServiceContract $employees,
        RoleServiceContract $roles,
        DepartmentServiceContract $departments,
        SettingServiceContract $settings
    )
    {
        $this->employees = $employees;
        $this->roles = $roles;
        $this->departments = $departments;
        $this->settings = $settings;
        $this->middleware('employee.create', ['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('employees.index');
    }

    public function anyData()
    {
        $canUpdateEmployee = auth()->employee()->can('update-employee');
        $employees = Employee::select(['id', 'name', 'email', 'work_number']);
        return Datatables::of($employees)
            ->addColumn('namelink', function ($employees) {
                return '<a href="employees/' . $employees->id . '" ">' . $employees->name . '</a>';
            })
            ->add_column('edit', '
                <a href="{{ route(\'employees.edit\', $id) }}" class="btn btn-success" >Edit</a>')
            ->add_column('delete', '
                <form action="{{ route(\'employees.destroy\', $id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" name="submit" value="Delete" class="btn btn-danger" onClick="return confirm(\'Are you sure?\')"">

            {{csrf_field()}}
            </form>')
            ->make(true);
    }

    public function ticketData($id)
    {
        $tickets = Ticket::select(
            ['id', 'title', 'created_at', 'deadline', 'fk_employee_id_assign']
        )
            ->where('fk_employee_id_assign', $id)->where('status_id', 1);
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="' . route('tickets.show', $tickets->id) . '">' . $tickets->title . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }

    public function closedTicketData($id)
    {
        $tickets = Ticket::select(
            ['id', 'title', 'created_at', 'deadline', 'fk_employee_id_assign']
        )
            ->where('fk_employee_id_assign', $id)->where('status_id', 2);
        return Datatables::of($tickets)
            ->addColumn('titlelink', function ($tickets) {
                return '<a href="' . route('tickets.show', $tickets->id) . '">' . $tickets->title . '</a>';
            })
            ->editColumn('created_at', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tickets) {
                return $tickets->created_at ? with(new Carbon($tickets->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }

    public function relationData($id)
    {
        $relations = Relation::select(['id', 'name', 'company_name', 'primary_number', 'email'])->where('fk_employee_id', $id);
        return Datatables::of($relations)
            ->addColumn('relationlink', function ($relations) {
                return '<a href="' . route('relations.show', $relations->id) . '">' . $relations->name . '</a>';
            })
            ->editColumn('created_at', function ($relations) {
                return $relations->created_at ? with(new Carbon($relations->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($relations) {
                return $relations->created_at ? with(new Carbon($relations->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('employees.create')
            ->withRoles($this->roles->listAllRoles())
            ->withDepartments($this->departments->listAllDepartments());
    }

    /**
     * Store a newly created resource in storage.
     * @param Employee $employee
     * @return Response
     */
    public function store(StoreEmployeeRequest $employeeRequest)
    {
        $getInsertedId = $this->employees->create($employeeRequest);
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return view('employees.show')
            ->withEmployee($this->employees->find($id))
            ->withCompanyname($this->settings->getCompanyName());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('employees.edit')
            ->withEmployee($this->employees->find($id))
            ->withRoles($this->roles->listAllRoles())
            ->withDepartment($this->departments->listAllDepartments());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, UpdateEmployeeRequest $request)
    {
        $this->employees->update($id, $request);
        Session()->flash('flash_message', 'Employee successfully updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->employees->destroy($id);
        return redirect()->route('employees.index');
    }
}
