<?php

namespace App\Handlers;

/**
 * This file is part of the Laravel package: Menu-Builder,
 * a menu and breadcrumb trails management solution for Laravel.
 *
 * @license GPLv3
 * @package sroutier\MenuBuilder
 */

use App\Contracts\MenuHandlerInterface;
use App\Traits\MenuHandlerTrait;
use App\Exceptions\MenuBuilderMenuItemNotFoundException;
use Auth;
use Log;

use App\Models\Menu;
use App\Models\Route;

class LESKSecuredMenuHandler implements MenuHandlerInterface
{

    use MenuHandlerTrait {
        renderMenuItem  as traitRenderMenuItem;
        generateUrl     as traitGenerateUrl;
        getLeafMenuItem as traitGetLeafMenuItem;
    }

    public $MENU_PARTIAL_VIEW       = 'partials._adminlte-menu-sidebar';
    public $MENU_HEADER             = "";
    public $MENU_FOOTER             = "";
    public $MENU_ITEM_SEPARATOR     = "<li role='separator' class='divider'></li>";
    public $MENU_ITEM_INACTIVE      = "<li><a href='@URL@'><i class='@ICON@'></i>&nbsp;<span>@LABEL@</span></a></li>";
    public $MENU_ITEM_ACTIVE        = "<li class='active'><a href='@URL@'><i class='@ICON@'></i>&nbsp;<span>@LABEL@</span><span class='sr-only'>(current)</span></a></li>";
    public $MENU_GROUP_START        = "<li class='treeview'><a href='@URL@'><i class='@ICON@'></i><span>@LABEL@</span><i class='fa fa-angle-left pull-right'></i></a><ul class='treeview-menu'>";
    public $MENU_GROUP_START_OPENED = "<li class='treeview active'><a href='@URL@'><i class='@ICON@'></i><span>@LABEL@</span><i class='fa fa-angle-down pull-right'></i></a><ul class='treeview-menu menu-open'>";
    public $MENU_GROUP_START_CLOSED = "<li class='treeview'><a href='@URL@'><i class='@ICON@'></i><span>@LABEL@</span><i class='fa fa-angle-left pull-right'></i></a><ul class='treeview-menu'>";
    public $MENU_GROUP_END          = "</ul></li>";

    public $TRAIL_PARTIAL_VIEW           = 'partials._bootstrap-light-trail';
    public $TRAIL_HEADER                 = "<ol class='breadcrumb'>";
    public $TRAIL_FOOTER                 = "</ol>";
    public $TRAIL_ITEM_ACTIVE_NO_URL     = "<li class='active'><i class='@ICON@'></i>&nbsp;@LABEL@</li>";
    public $TRAIL_ITEM_ACTIVE_WITH_URL   = "<li class='active'><a href='@URL@'><i class='@ICON@'></i>&nbsp;@LABEL@</a></li>";
    public $TRAIL_ITEM_INACTIVE_NO_URL   = "<li><i class='@ICON@'></i>&nbsp;@LABEL@</li>";
    public $TRAIL_ITEM_INACTIVE_WITH_URL = "<li><a href='@URL@'><i class='@ICON@'></i>&nbsp;@LABEL@</a></li>";


    public function renderMenuItem( Menu $item, $variables = [], $menuBranch = [] )
    {
        $itemContent = "";

        if ($this->currentStaffIsAuthorized($item)) {
            $itemContent = $this->traitRenderMenuItem($item, $variables, $menuBranch);
        }

        return $itemContent;
    }


    public function currentStaffIsAuthorized( Menu $item )
    {
        $authorized     = false;
        $perm           = null;
        $guest          = false;
        $staffname       = null;
        $staff           = null;


        // Get current staff or set guest to true for unauthenticated staff.
        if ( \Auth::check() ) {
            $staff       = \Auth::user();
            $staffname   = $staff->username;
        } elseif ( \Auth::guest() ) {
            $guest      = true;
        }

        // Get effective permission for menu entry.
        $route = $item->route;
        if ($route instanceof Route) {
            $perm = $route->permission;
        }
        else {
            $perm = $item->permission;
        }


        // Permission set for route.
        if ( isset($perm) ) {
            // Route is open to all.
            // TODO: Get 'open-to-all' role name from config, and replace all occurrences.
            if ( 'open-to-all' == $perm->name ) {
                $authorized = true;
            }
            // TODO: Get 'guest-only' role name from config, and replace all occurrences.
            // Staff is guest/unauthenticated and the route is restricted to guests.
            elseif ( $guest && 'guest-only' == $perm->name ) {
                $authorized = true;
            }
            // The staff has the permission required by the route.
            elseif ( !$guest && isset($staff) && ($staff->enabled) && $staff->can($perm->name) ) {
                $authorized = true;
            }
            // If all checks fail.
            else {
                Log::info("Authorization denied for menu [" . $item->name . "], guest [" . $guest . "], username [" . $staffname . "].");
            }
        }
        // If item has children it may be rendered if any of the children is rendered.
        elseif ($item->children->count() > 0)
        {
            $authorized = true;
        }
        // If all checks fail.
        else {
            Log::info("Menu has no children and/or no permission set for the requested menu [" . $item->name . "], guest [" . $guest . "], username [" . $staffname . "].");
        }

        return $authorized;

    }
    

    public function generateUrl( Menu $menu )
    {
        $url = null;

        $route = $menu->route;
        if ($route instanceof Route) {
            $url = $route->path;
            $url = $this->fixUrl($url);
        }
        else {
            $url = $this->traitGenerateUrl($menu);
        }

        // Fix #55: Fix the url to add the basepath in case where
        // the application is hosted in a subdirectory.
        $base = \Request::getBasePath();
        if ($base) {
            $url = $base . $url;
        }

        return $url;
    }


    public function fixUrl( $url)
    {
        $result = preg_match("#[a-z0-9\-\._]+:\/\/#i", $url);
        if($result == 0)
        {
            $url = '/' . $url;
        }

        return $url;
    }

    public function getLeafMenuItem( Menu $leaf = null )
    {
        // Get the leaf menu item from the value passed in.
        try {
            $leaf = $this->traitGetLeafMenuItem($leaf);
            return $leaf;
        }
        catch (MenuBuilderMenuItemNotFoundException $ex) {
            // Eat the exception as we want a chance to find it from the current route.
        }

        // if the leaf node was not found from the passed in value, try to get it from the current route.
        $routeLaravel = $this->app->request->route();
        $routeAction = $routeLaravel->getAction();
        $routeName = $routeAction['as'];
        $routeLesk = Route::where('name', $routeName)->first();
        if ($routeLesk instanceof Route) {
            $leaf = $this->menuRepository->findBy('route_id', $routeLesk->id);
            if ($leaf instanceof Menu) {
                return $leaf;
            }
        }

        // Could not find the requested menu item, throwing an exception.
        throw new MenuBuilderMenuItemNotFoundException("Menu item [".$leaf."] not found for URL [".$routeName."].");

    }



}
