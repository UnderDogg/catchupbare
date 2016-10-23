<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;


use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Libraries\Arr;
use App\Libraries\Str;
use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use App\Repositories\Criteria\Permission\PermissionsByNamesAscending;
use App\Repositories\Criteria\Role\RolesByNamesAscending;
use App\Repositories\Criteria\Role\RolesWhereDisplayNameOrDescriptionLike;
use App\Repositories\Criteria\Role\RolesWithPermissions;

use Modules\Core\Models\Staff;
use Modules\Core\Models\Permission;
use Modules\Core\Models\Role;

use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    /**
     * @var Role
     */
    private $role;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var Staff
     */
    private $staff;

    /**
     * @param Application $app
     * @param Audit $audit
     * @param Role $role
     * @param Permission $permission
     * @param Staff $staff
     */
    public function __construct(Application $app, Audit $audit, Role $role, Permission $permission, Staff $staff)
    {
        parent::__construct($app, $audit);
        $this->role = $role;
        $this->permission = $permission;
        $this->staff = $staff;
    }


    public function anyData()
    {
        $roles = Role::select(['id', 'name', 'display_name',]);
        return Datatables::of($roles)

            ->addColumn('rolenamelink', function ($roles) {
                return '<a href="adminpanel/roles/' . $roles->id . '" ">' . $roles->name . '</a>';
            })
            ->addColumn('permissionslink', function ($roles) {
                return '<a href="adminpanel/roles/' . $roles->id . '" ">' . $roles->display_name . '</a>';
            })

            ->addColumn('stafflink', function ($roles) {
                return '<a href="adminpanel/roles/' . $roles->id . '" ">' . $roles->display_name . '</a>';
            })

            ->addColumn('actions', function ($roles) {
                return '
                <form action="' . route('admin.roles.destroy', [$roles->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('admin.roles.edit', [$roles->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }



    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans('core::admin/roles/general.page.index.title'); // "Admin | Roles";
        $page_description = trans('core::admin/roles/general.page.index.description'); // "List of roles";

        return view('core::admin.roles.index', compact('roles', 'page_title', 'page_description'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->role->find($id);

        $page_title = trans('core::admin/roles/general.page.show.title'); // "Admin | Role | Show";
        $page_description = trans('core::admin/roles/general.page.show.description', ['name' => $role->name]); // "Displaying role";

        $perms = $this->permission->all();

        return view('admin.roles.show', compact('role', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('core::admin/roles/general.page.create.title'); // "Admin | Role | Create";
        $page_description = trans('core::admin/roles/general.page.create.description'); // "Creating a new role";

        $role = new \App\Models\Role();
        $perms = $this->permission->all();

        return view('admin.roles.create', compact('role', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $this->validate($request, array('name' => 'required|unique:roles',
            'display_name' => 'required'
        ));

        $attributes = $request->all();

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-store', ['name' => $attributes['name']]));

        if ((array_key_exists('selected_staffs', $attributes)) && (!empty($attributes['selected_staffs']))) {
            $attributes['staff'] = explode(",", $attributes['selected_staffs']);
        } else {
            $attributes['staff'] = null;
        }

        $role = $this->role->create($attributes);

        $role->savePermissions($request->get('perms'));
        $role->forcePermission('basic-authenticated');
        $role->saveStaff($attributes['staff']);

        Flash::success(trans('core::admin/roles/general.status.created')); // 'Role successfully created');

        return redirect('/admin/roles');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->role->find($id);

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-edit', ['name' => $role->name]));

        $page_title = trans('core::admin/roles/general.page.edit.title'); // "Admin | Role | Edit";
        $page_description = trans('core::admin/roles/general.page.edit.description', ['name' => $role->name]); // "Editing role";

        if (!$role->isEditable() && !$role->canChangePermissions()) {
            abort(403);
        }

        $perms = $this->permission->all();

        return view('admin.roles.edit', compact('role', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array('name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
        ));

        $role = $this->role->find($id);

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-update', ['name' => $role->name]));

        $attributes = $request->all();

        if ((array_key_exists('selected_staffs', $attributes)) && (!empty($attributes['selected_staffs']))) {
            $attributes['staff'] = explode(",", $attributes['selected_staffs']);
        } else {
            $attributes['staff'] = [];
        }

        if ($role->isEditable()) {
            $role->update($attributes);
        }

        if ($role->canChangePermissions()) {
            $role->savePermissions($request->get('perms'));
        }

        $role->forcePermission('basic-authenticated');

        if ($role->canChangeMembership()) {
            $role->saveStaff($attributes['staff']);
        }

        Flash::success(trans('core::admin/roles/general.status.updated')); // 'Role successfully updated');

        return redirect('/admin/roles');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $role = $this->role->find($id);

        if (!$role->isdeletable()) {
            abort(403);
        }

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-destroy', ['name' => $role->name]));

        $this->role->delete($id);

        Flash::success(trans('core::admin/roles/general.status.deleted')); // 'Role successfully deleted');

        return redirect('/admin/roles');
    }

    /**
     * Delete Confirm
     *
     * @param   int $id
     *
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error = null;

        $role = $this->role->find($id);

        if (!$role->isdeletable()) {
            abort(403);
        }

        $modal_title = trans('core::admin/roles/dialog.delete-confirm.title');

        $role = $this->role->find($id);
        $modal_route = route('admin.roles.delete', array('id' => $role->id));

        $modal_body = trans('core::admin/roles/dialog.delete-confirm.body', ['id' => $role->id, 'name' => $role->name]);

        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $role = $this->role->find($id);

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-enable', ['name' => $role->name]));

        $role->enabled = true;
        $role->save();

        Flash::success(trans('core::admin/roles/general.status.enabled'));

        return redirect('/admin/roles');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        //TODO: Should we protect 'admins', 'staff'??

        $role = $this->role->find($id);

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-disabled', ['name' => $role->name]));

        $role->enabled = false;
        $role->save();

        Flash::success(trans('core::admin/roles/general.status.disabled'));

        return redirect('/admin/roles');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkRoles = $request->input('chkRole');

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-enabled-selected'), $chkRoles);

        if (isset($chkRoles)) {
            foreach ($chkRoles as $role_id) {
                $role = $this->role->find($role_id);
                $role->enabled = true;
                $role->save();
            }
            Flash::success(trans('core::admin/roles/general.status.global-enabled'));
        } else {
            Flash::warning(trans('core::admin/roles/general.status.no-role-selected'));
        }
        return redirect('/admin/roles');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        //TODO: Should we protect 'admins', 'staff'??

        $chkRoles = $request->input('chkRole');

        Audit::log(Auth::user()->id, trans('core::admin/roles/general.audit-log.category'), trans('core::admin/roles/general.audit-log.msg-disabled-selected'), $chkRoles);

        if (isset($chkRoles)) {
            foreach ($chkRoles as $role_id) {
                $role = $this->role->find($role_id);
                $role->enabled = false;
                $role->save();
            }
            Flash::success(trans('core::admin/roles/general.status.global-disabled'));
        } else {
            Flash::warning(trans('core::admin/roles/general.status.no-role-selected'));
        }
        return redirect('/admin/roles');
    }

    /**
     * @param Request $request
     *
     * @return array|static[]
     */
    public function searchByName(Request $request)
    {
        $return_arr = null;

        $query = $request->input('query');

        $roles = $this->role->pushCriteria(new RolesWhereDisplayNameOrDescriptionLike($query))->all();

        foreach ($roles as $role) {
            $id = $role->id;
            $display_name = $role->display_name;
            $description = $role->description;

            $entry_arr = ['id' => $id, 'text' => "$display_name ($description)"];
            $return_arr[] = $entry_arr;
        }

        return $return_arr;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id = $request->input('id');
        $role = $this->role->find($id);

        return $role;
    }

}