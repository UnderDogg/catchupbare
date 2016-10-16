<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Libraries\Arr;
use App\Libraries\Str;
use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use App\Repositories\Criteria\Permission\PermissionsByNamesAscending;
use App\Repositories\Criteria\Role\RolesByNamesAscending;
use App\Repositories\Criteria\Staff\StaffByUsernamesAscending;
use App\Repositories\Criteria\Staff\StaffWhereFirstNameOrLastNameOrStaffnameLike;
use App\Repositories\Criteria\Staff\StaffWithRoles;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use App\Repositories\StaffRepository as Staff;
use Auth;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Mail;

class StaffController extends Controller
{

    /**
     * @var Staff
     */
    protected $staff;

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var Permission
     */
    protected $perm;

    /**
     * @param Staff $staff
     * @param Role $role
     */
    public function __construct(Application $app, Audit $audit, Staff $staff, Role $role, Permission $perm)
    {
        parent::__construct($app, $audit);
        $this->staff  = $staff;
        $this->role  = $role;
        $this->perm  = $perm;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-index'));

        $page_title = trans('admin/staff/general.page.index.title'); // "Admin | Staff";
        $page_description = trans('admin/staff/general.page.index.description'); // "List of staff";

        $staff = $this->staff->pushCriteria(new StaffWithRoles())->pushCriteria(new StaffByUsernamesAscending())->paginate(10);
        return view('admin.staff.index', compact('staff', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $staff = $this->staff->find($id);

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-show', ['username' => $staff->username]));

        $page_title = trans('admin/staff/general.page.show.title'); // "Admin | Staff | Show";
        $page_description = trans('admin/staff/general.page.show.description', ['full_name' => $staff->full_name]); // "Displaying staff";

        $perms = $this->perm->pushCriteria(new PermissionsByNamesAscending())->all();

        $theme = $staff->settings()->get('theme', null);
        $time_zone = $staff->settings()->get('time_zone', null);
        $time_format = $staff->settings()->get('time_format', null);
        $locales = (new Setting())->get('app.supportedLocales');
        $localeIdent = $staff->settings()->get('locale', null);
        if (!Str::isNullOrEmptyString($localeIdent)) {
            $locale = $locales[$localeIdent];
        } else {
            $locale = "";
        }

        return view('admin.staff.show', compact('staff', 'perms', 'theme', 'time_zone', 'time_format', 'locale', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans('admin/staff/general.page.create.title'); // "Admin | Staff | Create";
        $page_description = trans('admin/staff/general.page.create.description'); // "Creating a new staff";

        $perms = $this->perm->pushCriteria(new PermissionsByNamesAscending())->all();
        $staff = new \App\Staff();

        $themes = \Theme::getList();
        $themes = Arr::indexToAssoc($themes, true);
        $theme = $staff->settings()->get('theme', null);

        $time_zones = \DateTimeZone::listIdentifiers();
        $time_zone = $staff->settings()->get('time_zone', null);
        $tzKey = array_search($time_zone, $time_zones);

        $time_format = $staff->settings()->get('time_format', null);

        $locales = (new Setting())->get('app.supportedLocales');
        $locale = $staff->settings()->get('locale', null);

        return view('admin.staff.create', compact('staff', 'perms', 'themes', 'theme', 'time_zones', 'tzKey', 'time_format', 'locale', 'locales', 'page_title', 'page_description'));
    }

    /**
     * @param CreateStaffRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateStaffRequest $request)
    {
        $this->validate($request, \app\Staff::getCreateValidationRules());

        $attributes = $request->all();

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-store', ['username' => $attributes['username']]));

        if ( (array_key_exists('selected_roles', $attributes)) && (!empty($attributes['selected_roles'])) ) {
            $attributes['role'] = explode(",", $attributes['selected_roles']);
        } else {
            $attributes['role'] = [];
        }

        // Create basic staff.
        $staff = $this->staff->create($attributes);
        // Run the update method to set enabled status and roles membership.
        $staff->update($attributes);

        Flash::success( trans('admin/staff/general.status.created') ); // 'Staff successfully created');

        return redirect('/admin/staff');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $staff = $this->staff->find($id);

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-edit', ['username' => $staff->username]));

        $page_title = trans('admin/staff/general.page.edit.title'); // "Admin | Staff | Edit";
        $page_description = trans('admin/staff/general.page.edit.description', ['full_name' => $staff->full_name]); // "Editing staff";

        $roles = $this->role->pushCriteria(new RolesByNamesAscending())->all();
        $perms = $this->perm->pushCriteria(new PermissionsByNamesAscending())->all();

        $themes = \Theme::getList();
        $themes = Arr::indexToAssoc($themes, true);
        $theme = $staff->settings()->get('theme', null);

        $time_zones = \DateTimeZone::listIdentifiers();
        $time_zone = $staff->settings()->get('time_zone', null);
        $tzKey = array_search($time_zone, $time_zones);

        $time_format = $staff->settings()->get('time_format', null);

        $locales = (new Setting())->get('app.supportedLocales');
        $locale = $staff->settings()->get('locale', null);

        return view('admin.staff.edit', compact('staff', 'roles', 'perms', 'themes', 'theme', 'time_zones', 'tzKey', 'time_format', 'locale', 'locales', 'page_title', 'page_description'));
    }

    static public function ParseUpdateAuditLog($id)
    {
        $permsObj = [];
        $permsNoFound = [];
        $rolesObj = [];
        $rolesNotFound = [];

        $audit   = \App\Models\Audit::find($id);
        $dataAtt = json_decode($audit->data, true);

        // Lookup and load the perms that we can still find, otherwise add to an separate array.
        if (array_key_exists('perms', $dataAtt)) {
            foreach($dataAtt['perms'] as $id) {
                $perm = \App\Models\Permission::find($id);
                if ($perm) {
                    $permsObj[] = $perm;
                }
                else {
                    $permsNoFound[] = trans('admin/staff/general.error.perm_not_found', ['id' => $id]);
                }
            }
        }
        $dataAtt['permsObj'] = $permsObj;
        $dataAtt['permsNotFound'] = $permsNoFound;

        // Lookup and load the roles that we can still find, otherwise add to an separate array.
        if (array_key_exists('selected_roles', $dataAtt)) {
            $aRolesIDs = explode(",", $dataAtt['selected_roles']);
            foreach($aRolesIDs as $id) {
                $role = \App\Models\Role::find($id);
                if ($role) {
                    $rolesObj[] = $role;
                }
                else {
                    $rolesNotFound[] = trans('admin/staff/general.error.perm_not_found', ['id' => $id]);
                }
            }
        }
        $dataAtt['rolesObj'] = $rolesObj;
        $dataAtt['rolesNotFound'] = $rolesNotFound;

        // Add the file name of the partial (blade) that will render this data.
        $dataAtt['show_partial'] = 'admin/staff/_audit_log_data_viewer_update';

        return $dataAtt;
    }

    /**
     * Loads the audit log item from the id passed in, locate the relevant staff, then overwrite all current attributes
     * of the staff with the values from the audit log data field. Once the staff saved, redirect to the edit page,
     * where the operator can inspect and further edit if needed.
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function replayEdit($id)
    {
        // Loading the audit in question.
        $audit = $this->audit->find($id);
        // Getting the attributes from the data fields.
        $att = json_decode($audit->data, true);
        // Finding the staff to operate on from the id field that was populated in the
        // edit action that created this audit record.
        $staff = $this->staff->find($att['id']);

        if (null == $staff) {
            Flash::warning( trans('admin/staff/general.error.staff_not_found', [ 'id' => $att['id'] ]) );
            return \Redirect::route('admin.audit.index');
        }

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-replay-edit', ['username' => $staff->username]));

        $page_title = trans('admin/staff/general.page.edit.title'); // "Admin | Staff | Edit";
        $page_description = trans('admin/staff/general.page.edit.description', ['full_name' => $staff->full_name]); // "Editing staff";

        if (!$staff->isEditable())
        {
            abort(403);
        }

        // Setting staff attributes with values from audit log to replay the requested action.
        // Password is not replayed.
        $staff->first_name = $att['first_name'];
        $staff->last_name = $att['last_name'];
        $staff->username = $att['username'];
        $staff->email = $att['email'];
        $staff->enabled = $att['enabled'];
        if (array_key_exists('selected_roles', $att)) {
            $aRoleIDs = explode(",", $att['selected_roles']);
            $staff->roles()->sync($aRoleIDs);
        }
        if (array_key_exists('perms', $att)) {
            $staff->permissions()->sync($att['perms']);
        }
        $staff->save();


        $roles = $this->role->all();
        $perms = $this->perm->all();

        return view('admin.staff.edit', compact('staff', 'roles', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @param UpdateStaffRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        $this->validate($request, \app\Staff::getUpdateValidationRules($id));

        $staff = $this->staff->find($id);

        // Get all attribute from the request.
        $attributes = $request->all();

        // Set passwordChanged flag
        $passwordChanged = false;
        // Fix #17 as per @sloan58
        // Check if the password was submitted and has changed.
        if(!\Hash::check($attributes['password'],$staff->password) && $attributes['password'] != '')
        {
            // Password was changed, set flag for later.
            $passwordChanged = true;
        }
        else
        {
            // Password was not changed or was not submitted, delete attribute from array to prevent it
            // from being set to blank.
            unset($attributes['password']);
            // Set flag just to be sure
            $passwordChanged = false;
        }

        // Get a copy of the attributes that we will modify to save for a replay.
        $replayAtt = $attributes;
        // Add the id of the current staff for the replay action.
        $replayAtt["id"] = $id;
        // Create log entry with replay data.
        $tmp = Audit::log( Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-update', ['username' => $staff->username]),
            $replayAtt, "App\Http\Controllers\StaffController::ParseUpdateAuditLog", "admin.staff.replay-edit" );


        if ( (array_key_exists('selected_roles', $attributes)) && (!empty($attributes['selected_roles'])) ) {
            $attributes['role'] = explode(",", $attributes['selected_roles']);
        } else {
            $attributes['role'] = [];
        }

        if ($staff->isRoot())
        {
            // Prevent changes to some fields for the root staff.
            unset($attributes['username']);
            unset($attributes['first_name']);
            unset($attributes['last_name']);
            unset($attributes['enabled']);
            unset($attributes['selected_roles']);
            unset($attributes['role']);
            unset($attributes['perms']);
        }

        $staff->update($attributes);
        if ($passwordChanged) {
            $staff->emailPasswordChange();
        }

        Flash::success( trans('admin/staff/general.status.updated') );

        return redirect('/admin/staff');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $staff = $this->staff->find($id);

        if (!$staff->isdeletable())
        {
            abort(403);
        }

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-destroy', ['username' => $staff->username]));

        $this->staff->delete($id);

        Flash::success( trans('admin/staff/general.status.deleted') );

        return redirect('/admin/staff');
    }

    /**
     * Delete Confirm
     *
     * @param   int   $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error = null;

        $staff = $this->staff->find($id);

        if (!$staff->isdeletable())
        {
            abort(403);
        }

        $modal_title = trans('admin/staff/dialog.delete-confirm.title');

        if (Auth::user()->id !== $id) {
            $staff = $this->staff->find($id);
            $modal_route = route('admin.staff.delete', array('id' => $staff->id));

            $modal_body = trans('admin/staff/dialog.delete-confirm.body', ['id' => $staff->id, 'full_name' => $staff->full_name]);
        }
        else
        {
            $error = trans('admin/staff/general.error.cant-delete-yourself');
        }
        return view('modal_confirmation', compact('error', 'modal_route', 'modal_title', 'modal_body'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $staff = $this->staff->find($id);

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-enable', ['username' => $staff->username]));

        $staff->enabled = true;
        $staff->save();

        Flash::success(trans('admin/staff/general.status.enabled'));

        return redirect('/admin/staff');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        $staff = $this->staff->find($id);

        if (!$staff->canBeDisabled())
        {
            Flash::error(trans('admin/staff/general.error.cant-be-disabled'));
        }
        else
        {
            Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-disabled', ['username' => $staff->username]));

            $staff->enabled = false;
            $staff->save();
            Flash::success(trans('admin/staff/general.status.disabled'));
        }

        return redirect('/admin/staff');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkStaff = $request->input('chkStaff');

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-enabled-selected'), $chkStaff);

        if (isset($chkStaff))
        {
            foreach ($chkStaff as $staff_id)
            {
                $staff = $this->staff->find($staff_id);
                $staff->enabled = true;
                $staff->save();
            }
            Flash::success(trans('admin/staff/general.status.global-enabled'));
        }
        else
        {
            Flash::warning(trans('admin/staff/general.status.no-staff-selected'));
        }
        return redirect('/admin/staff');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        $chkStaff = $request->input('chkStaff');

        Audit::log(Auth::user()->id, trans('admin/staff/general.audit-log.category'), trans('admin/staff/general.audit-log.msg-disabled-selected'), $chkStaff);

        if (isset($chkStaff))
        {
            foreach ($chkStaff as $staff_id)
            {
                $staff = $this->staff->find($staff_id);
                if (!$staff->canBeDisabled())
                {
                    Flash::error(trans('admin/staff/general.error.cant-be-disabled'));
                }
                else
                {
                    $staff->enabled = false;
                    $staff->save();
                }
            }
            Flash::success(trans('admin/staff/general.status.global-disabled'));
        }
        else
        {
            Flash::warning(trans('admin/staff/general.status.no-staff-selected'));
        }
        return redirect('/admin/staff');
    }

    public function searchByName(Request $request)
    {
        $return_arr = null;

        $query = $request->input('query');

        $staffs = $this->staff->pushCriteria(new StaffWhereFirstNameOrLastNameOrStaffnameLike($query))->all();

        foreach ($staffs as $staff) {
            $id = $staff->id;
            $first_name = $staff->first_name;
            $last_name = $staff->last_name;
            $staffname = $staff->username;

            $entry_arr = [ 'id' => $id, 'text' => "$first_name $last_name ($staffname)"];
            $return_arr[] = $entry_arr;
        }

        return $return_arr;
    }

    public function listByPage(Request $request)
    {
        $skipNumb = $request->input('s');
        $takeNumb = $request->input('t');

        $staffCollection = \App\Staff::skip($skipNumb)->take($takeNumb)
            ->get(['id', 'first_name', 'last_name', 'username'])
            ->lists('full_name_and_staffname', 'id');
        $staffList = $staffCollection->all();

        return $staffList;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id = $request->input('id');
        $staff = $this->staff->find($id);

        return $staff;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $staff = Auth::user();

        Audit::log(Auth::user()->id, trans('general.audit-log.category-profile'), trans('general.audit-log.msg-profile-show', ['username' => $staff->username]));

        $page_title = trans('general.page.profile.title');
        $page_description = trans('general.page.profile.description', ['full_name' => $staff->full_name]);
        $readOnlyIfLDAP = ('ldap' == $staff->auth_type) ? 'readonly' : '';
        $perms = $this->perm->pushCriteria(new PermissionsByNamesAscending())->all();

        $themes = \Theme::getList();
        $themes = Arr::indexToAssoc($themes, true);
        $theme = $staff->settings()->get('theme');

        $time_zones = \DateTimeZone::listIdentifiers();
        $time_zone = $staff->settings()->get('time_zone');
        $tzKey = array_search($time_zone, $time_zones);

        $time_format = $staff->settings()->get('time_format');

        $locales = (new Setting())->get('app.supportedLocales');
        $locale = $staff->settings()->get('locale');

        return view('staff.profile', compact('staff', 'perms', 'themes', 'theme', 'time_zones', 'tzKey', 'time_format', 'locale', 'locales', 'readOnlyIfLDAP', 'page_title', 'page_description'));
    }

    /**
     * @param UpdateStaffRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function profileUpdate(UpdateStaffRequest $request)
    {
        $staff = Auth::user();

        $this->validate($request, \app\Staff::getUpdateValidationRules($staff->id));

        Audit::log(Auth::user()->id, trans('general.audit-log.category-profile'), trans('general.audit-log.msg-profile-update', ['username' => $staff->username]));

        // Get all attribute from the request.
        $attributes = $request->all();

        // Set passwordChanged flag
        $passwordChanged = false;
        // Fix #17 as per @sloan58
        // Check if the password was submitted and has changed.
        if(!\Hash::check($attributes['password'],$staff->password) && $attributes['password'] != '')
        {
            // Password was changed, set flag for later.
            $passwordChanged = true;
        }
        else
        {
            // Password was not changed or was not submitted, delete attribute from array to prevent it
            // from being set to blank.
            unset($attributes['password']);
            // Set flag just to be sure
            $passwordChanged = false;
        }
        // Prevent changes to some fields for the root staff.
        if ($staff->isRoot())
        {
            unset($attributes['username']);
            unset($attributes['first_name']);
            unset($attributes['last_name']);
            unset($attributes['enabled']);
        }

        // Fix: Editing the profile does not allow to edit the Roles and permissions only to see them.
        // So load the attribute array with current roles and perms to prevent them from being erased.
        $role_ids = [];
        foreach ($staff->roles as $role) {
            $role_ids[] = $role->id;
        }
        $attributes['role'] = $role_ids;

        $perm_ids = [];
        foreach ($staff->permissions as $perm) {
            $perm_ids[] = $perm->id;
        }
        $attributes['perms'] = $perm_ids;


        // Update staff properties.
        $staff->update($attributes);
        if ($passwordChanged) {
            $staff->emailPasswordChange();
        }

        Flash::success( trans('general.status.profile.updated') );

        return redirect()->route('staff.profile');
    }

}