<?php

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Route;
use App\Staff;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ////////////////////////////////////
        // Load the routes
        Route::loadLaravelRoutes('/.*/');


        ////////////////////////////////////
        // Create basic set of permissions
        $permGuestOnly = Permission::create([
            'name'          => 'guest-only',
            'display_name'  => 'Guest only access',
            'description'   => 'Only guest staff can access these.',
            'enabled'       => true,
        ]);
        $permOpenToAll = Permission::create([
            'name'          => 'open-to-all',
            'display_name'  => 'Open to all',
            'description'   => 'Everyone can access these, even unauthenticated (guest) staff.',
            'enabled'       => true,
        ]);
        $permBasicAuthenticated = Permission::create([
            'name'          => 'basic-authenticated',
            'display_name'  => 'Basic authenticated',
            'description'   => 'Basic permission after being authenticated.',
            'enabled'       => true,
        ]);
        // Create a few permissions for the admin|security section
        $permManageMenus = Permission::create([
            'name'          => 'manage-menus',
            'display_name'  => 'Manage menus',
            'description'   => 'Allows a staff to manage the site menus.',
            'enabled'       => true,
        ]);
        $permManageStaff = Permission::create([
            'name'          => 'manage-staff',
            'display_name'  => 'Manage staff',
            'description'   => 'Allows a staff to manage the site staff.',
            'enabled'       => true,
        ]);
        $permManageRoles = Permission::create([
            'name'          => 'manage-roles',
            'display_name'  => 'Manage roles',
            'description'   => 'Allows a staff to manage the site roles.',
            'enabled'       => true,
        ]);
        $permManagePermissions = Permission::create([
            'name'          => 'manage-permissions',
            'display_name'  => 'Manage permissions',
            'description'   => 'Allows a staff to manage the site permissions.',
            'enabled'       => true,
        ]);
        $permManageRoutes = Permission::create([
            'name'          => 'manage-routes',
            'display_name'  => 'Manage routes',
            'description'   => 'Allows a staff to manage the site routes.',
            'enabled'       => true,
        ]);
        $permManageModules = Permission::create([
            'name'          => 'manage-modules',
            'display_name'  => 'Manage modules',
            'description'   => 'Allows a staff to manage the site modules.',
            'enabled'       => true,
        ]);
        // Create a few permissions for the admin|audit section
        $permAuditLogView = Permission::create([
            'name'          => 'audit-log-view',
            'display_name'  => 'View audit log',
            'description'   => 'Allows a staff to view the audit log.',
            'enabled'       => true,
        ]);
        $permAuditReplay = Permission::create([
            'name'          => 'audit-log-replay',
            'display_name'  => 'Replay audit log item',
            'description'   => 'Allows a staff to replay items from the audit log.',
            'enabled'       => true,
        ]);
        $permAuditPurge = Permission::create([
            'name'          => 'audit-log-purge',
            'display_name'  => 'Purge audit log',
            'description'   => 'Allows a staff to purge old items from the audit log.',
            'enabled'       => true,
        ]);
        // Create permission to manage the site settings
        $permAdminSettings = Permission::create([
            'name'          => 'admin-settings',
            'display_name'  => 'Administer site settings',
            'description'   => 'Allows a staff to change site settings.',
            'enabled'       => true,
        ]);
        // Create a few permissions for the admin|errors section
        $permErrorLogView = Permission::create([
            'name'          => 'error-log-view',
            'display_name'  => 'View error log',
            'description'   => 'Allows a staff to view the error log.',
            'enabled'       => true,
        ]);
        $permErrorPurge = Permission::create([
            'name'          => 'error-log-purge',
            'display_name'  => 'Purge error log',
            'description'   => 'Allows a staff to purge old items from the error log.',
            'enabled'       => true,
        ]);


        ////////////////////////////////////
        // Associate open-to-all permission to some routes
        $routeBackslash = Route::where('name', 'backslash')->get()->first();
        $routeBackslash->permission()->associate($permOpenToAll);
        $routeBackslash->save();
        $routeHome = Route::where('name', 'home')->get()->first();
        $routeHome->permission()->associate($permOpenToAll);
        $routeHome->save();
        $routeWelcome = Route::where('name', 'welcome')->get()->first();
        $routeWelcome->permission()->associate($permOpenToAll);
        $routeWelcome->save();
        $routeFaust = Route::where('name', 'faust')->get()->first();
        $routeFaust->permission()->associate($permOpenToAll);
        $routeFaust->save();
        // Associate basic-authenticated permission to some routes
        $routeDashboard = Route::where('name', 'dashboard')->get()->first();
        $routeDashboard->permission()->associate($permBasicAuthenticated);
        $routeDashboard->save();
        $routeStaffProfile = Route::where('name', 'staff.profile')->get()->first();
        $routeStaffProfile->permission()->associate($permBasicAuthenticated);
        $routeStaffProfile->save();
        $routeStaffProfilePatch = Route::where('name', 'staff.profile.patch')->get()->first();
        $routeStaffProfilePatch->permission()->associate($permBasicAuthenticated);
        $routeStaffProfilePatch->save();
        // Associate the audit-log permissions
        $routeAuditView = Route::where('name', 'admin.audit.index')->get()->first();
        $routeAuditView->permission()->associate($permAuditLogView);
        $routeAuditView->save();
        $routeAuditShow = Route::where('name', 'admin.audit.show')->get()->first();
        $routeAuditShow->permission()->associate($permAuditLogView);
        $routeAuditShow->save();
        $routeAuditPurge = Route::where('name', 'admin.audit.purge')->get()->first();
        $routeAuditPurge->permission()->associate($permAuditPurge);
        $routeAuditPurge->save();
        $routeAuditReplay = Route::where('name', 'admin.audit.replay')->get()->first();
        $routeAuditReplay->permission()->associate($permAuditReplay);
        $routeAuditReplay->save();
        // Associate manage-menus permissions to routes starting with 'admin.menus.'
        $manageMenusRoutes = Route::where('name', 'like', "admin.menus.%")->get()->all();
        foreach ($manageMenusRoutes as $route)
        {
            $route->permission()->associate($permManageMenus);
            $route->save();
        }
        // Associate manage-permission permissions to routes starting with 'admin.permissions.'
        $managePermRoutes = Route::where('name', 'like', "admin.permissions.%")->get()->all();
        foreach ($managePermRoutes as $route)
        {
            $route->permission()->associate($permManagePermissions);
            $route->save();
        }
        // Associate manage-roles permissions to routes starting with 'admin.roles.'
        $manageRoleRoutes = Route::where('name', 'like', "admin.roles.%")->get()->all();
        foreach ($manageRoleRoutes as $route)
        {
            $route->permission()->associate($permManageRoles);
            $route->save();
        }
        // Associate manage-routes permissions to routes starting with 'admin.routes.'
        $manageRouteRoutes = Route::where('name', 'like', "admin.routes.%")->get()->all();
        foreach ($manageRouteRoutes as $route)
        {
            $route->permission()->associate($permManageRoutes);
            $route->save();
        }
        // Associate manage-modules permissions to routes starting with 'admin.modules.'
        $manageModulesRoutes = Route::where('name', 'like', "admin.modules.%")->get()->all();
        foreach ($manageModulesRoutes as $route)
        {
            $route->permission()->associate($permManageModules);
            $route->save();
        }
        // Associate manage-staff permissions to routes starting with 'admin.staff.'
        $manageStaffRoutes = Route::where('name', 'like', "admin.staff.%")->get()->all();
        foreach ($manageStaffRoutes as $route)
        {
            $route->permission()->associate($permManageStaff);
            $route->save();
        }
        // Associate the admin-settings permissions
        $routeAdminSettings = Route::where('name', 'admin.settings.index')->get()->first();
        $routeAdminSettings->permission()->associate($permAdminSettings);
        $routeAdminSettings->save();
        // Associate the error-log permissions
        $routeErrorView = Route::where('name', 'admin.errors.index')->get()->first();
        $routeErrorView->permission()->associate($permErrorLogView);
        $routeErrorView->save();
        $routeErrorShow = Route::where('name', 'admin.errors.show')->get()->first();
        $routeErrorShow->permission()->associate($permErrorLogView);
        $routeErrorShow->save();
        $routeErrorPurge = Route::where('name', 'admin.errors.purge')->get()->first();
        $routeErrorPurge->permission()->associate($permErrorPurge);
        $routeErrorPurge->save();


        ////////////////////////////////////



        // Create role: admins
        $roleAdmins = Role::create([
            "name"          => "admins",
            "display_name"  => "Administrators",
            "description"   => "Administrators have no restrictions",
            "enabled"       => true
        ]);



        // Create role: staff
        // Assign permission basic-authenticated
        $roleStaff = Role::create([
            "name"          => "staff",
            "display_name"  => "Staff",
            "description"   => "All authenticated staff",
            "enabled"       => true
        ]);
        $roleStaff->perms()->attach($permBasicAuthenticated->id);



        ////////////////////////////////////
        // Create staff: root
        // Assign membership to role admins, membership to role staff is
        // automatic.
        $staffRoot = Staff::create([
            "first_name"    => "Root",
            "last_name"     => "SuperStaff",
            "username"      => "root",
            "email"         => "root@email.com",
            "password"      => "Password1",
            "auth_type"     => "internal",
            "enabled"       => true
        ]);
        $staffRoot->roles()->attach(1);


        ////////////////////////////////////
        // Create menu: root
        $menuRoot = Menu::create([
//            'id'            => 0,                   // Hard-coded
            'name'          => 'root',
            'label'         => 'Root',
            'position'      => 0,
            'icon'          => 'fa fa-folder',      // No point setting this as root is not visible.
            'separator'     => false,
            'url'           => null,                // No URL, root is not rendered or visible.
            'enabled'       => true,                // Must be enabled or sub-menus will not be available.
//            'parent_id'     => 0,                   // Parent of itself.
            'route_id'      => null,                // No route, root cannot be reached.
            'permission_id' => $permOpenToAll->id,  // Must be visible to all, for all sub-menus to be visible.
        ]);
        // Force root parent to itself.
        $menuRoot->parent_id = $menuRoot->id;
        $menuRoot->save();
        // Create Home menu
        $menuHome = Menu::create([
            'name'          => 'home',
            'label'         => 'Home',
            'position'      => 0,
            'icon'          => 'fa fa-home fa-colour-green',
            'separator'     => false,
            'url'           => '/',
            'enabled'       => true,
            'parent_id'     => $menuRoot->id,       // Parent is root.
            'route_id'      => $routeHome->id,      // Route to home
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Dashboard menu
        $menuDashboard = Menu::create([
            'name'          => 'dashboard',
            'label'         => 'Dashboard',
            'position'      => 0,
            'icon'          => 'fa fa-dashboard',
            'separator'     => false,
            'url'           => '/dashboard',
            'enabled'       => true,
            'parent_id'     => $menuHome->id,       // Parent is root.
            'route_id'      => $routeDashboard->id,
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Admin container.
        $menuAdmin = Menu::create([
            'name'          => 'admin',
            'label'         => 'Admin',
            'position'      => 999,                 // Artificially high number to ensure that it is rendered last.
            'icon'          => 'fa fa-cog',
            'separator'     => false,
            'url'           => null,                // No url.
            'enabled'       => true,
            'parent_id'     => $menuRoot->id,       // Parent is root.
            'route_id'      => null,                // No route
            'permission_id' => null,                // Get permission from sub-items. If the staff has permission to see/use
                                                    // any sub-items, the admin menu will be rendered, otherwise it will
                                                    // not.
        ]);


        // Create Modules sub-menu
        $menuModules = Menu::create([
            'name'          => 'modules',
            'label'         => 'Modules',
            'position'      => 2,
            'icon'          => 'fa fa-puzzle-piece',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuAdmin->id,      // Parent is admin.
            'route_id'      => Route::where('name', 'like', "admin.modules.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);


        // Create Security container.
        $menuSecurity = Menu::create([
            'name'          => 'security',
            'label'         => 'Security',
            'position'      => 3,
            'icon'          => 'fa fa-staff-secret fa-colour-red',
            'separator'     => false,
            'url'           => null,                // No url.
            'enabled'       => true,
            'parent_id'     => $menuAdmin->id,      // Parent is admin.
            'route_id'      => null,                // No route
            'permission_id' => null,                // Get permission from sub-items.
        ]);


        // Create Menus sub-menu
        $menuMenus = Menu::create([
            'name'          => 'menus',
            'label'         => 'Menus',
            'position'      => 0,
            'icon'          => 'fa fa-bars',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => Route::where('name', 'like', "admin.menus.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);



        // Create separator
        $menuStaff = Menu::create([
            'name'          => 'menus-staff-separator',
            'label'         => '-----',
            'position'      => 1,
            'icon'          => null,
            'separator'     => true,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => null,
            'permission_id' => null,                // Get permission from route.
        ]);



        // Create Staff sub-menu
        $menuStaff = Menu::create([
            'name'          => 'staff',
            'label'         => 'Staff',
            'position'      => 2,
            'icon'          => 'fa fa-staff',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => Route::where('name', 'like', "admin.staff.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Roles sub-menu
        $menuRoles = Menu::create([
            'name'          => 'roles',
            'label'         => 'Roles',
            'position'      => 3,
            'icon'          => 'fa fa-staff',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => Route::where('name', 'like', "admin.roles.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Permissions sub-menu
        $menuPermissions = Menu::create([
            'name'          => 'permissions',
            'label'         => 'Permissions',
            'position'      => 4,
            'icon'          => 'fa fa-bolt',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => Route::where('name', 'like', "admin.permissions.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Routes sub-menu
        $menuRoutes = Menu::create([
            'name'          => 'routes',
            'label'         => 'Routes',
            'position'      => 5,
            'icon'          => 'fa fa-road',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuSecurity->id,   // Parent is security.
            'route_id'      => Route::where('name', 'like', "admin.routes.index")->get()->first()->id,
            'permission_id' => null,                // Get permission from route.
        ]);
        // Create Settings sub-menu
        $menuSettings = Menu::create([
            'name'          => 'setting',
            'label'         => 'Settings',
            'position'      => 4,
            'icon'          => 'fa fa-cogs',
            'separator'     => false,
            'url'           => null,                // Get URL from route.
            'enabled'       => true,
            'parent_id'     => $menuAdmin->id,      // Parent is admin.
            'route_id'      => $routeAdminSettings->id,
            'permission_id' => null,                // Get permission from route.
        ]);

    }
}
