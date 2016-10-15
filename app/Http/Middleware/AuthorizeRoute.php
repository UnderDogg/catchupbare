<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Route as LaravelRoute;
use App\Models\Route as AppRoute;
use Log;

class AuthorizeRoute
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorized     = false;    // Default to protect all routes.
        $errorCode      = 0;        // Default to something bogus...
        $method         = null;
        $path           = null;
        $actionName     = null;
        $staff           = null;
        $staffname       = null;
        $guest          = false;

        // Get current route from Laravel.
        $laravelRoute   = LaravelRoute::current();

        // If not set we will fallback to error HTTP 500. This should never occur. TODO: remove this check...
        if ( isset($laravelRoute) ) {
            // Get route info.
            $method     = $laravelRoute->getMethods()[0];
            $path       = $laravelRoute->getPath();
            $actionName = $laravelRoute->getActionName();

            // Get current staff or set guest to true for unauthenticated staff.
            if ( $this->auth->check() ) {
                $staff       = $this->auth->user();
                $staffname   = $staff->username;
            } elseif ( $this->auth->guest() ) {
                $guest      = true;
            }

            // AuthController and PasswordController are exempt from authorization.
            // TODO: Get list of controllers exempt from config.
            if (str_contains($actionName, 'AuthController@') ||
                str_contains($actionName, 'PasswordController@')
            ) {
                $authorized = true;
            }
            // Staff is 'root', all is authorized.
            // TODO: Get super staff name from config, and replace all occurrences.
            elseif (!$guest && isset($staff) && 'root' == $staff->username) {
                $authorized = true;
            }
            // Staff has the role 'admins', all is authorized.
            // TODO: Get 'admins' role name from config, and replace all occurrences.
            elseif (!$guest && isset($staff) && $staff->hasRole('admins')) {
                $authorized = true;
            }
            else {
//                if ($staff->enabled)
//                {
                // Get application route based on info from Laravel route.
                $appRoute = AppRoute::ofMethod($method)
                    ->ofActionName($actionName)
                    ->ofPath($path)
                    ->enabled()
                    ->with('permission')
                    ->first();
                // If found, proceed with authorization
                if ( isset($appRoute) ) {

                    // Permission set for route.
                    if ( isset($appRoute->permission) ) {
                        // Route is open to all.
                        // TODO: Get 'open-to-all' role name from config, and replace all occurrences.
                        if ( 'open-to-all' == $appRoute->permission->name ) {
                            $authorized = true;
                        }
                        // TODO: Get 'guest-only' role name from config, and replace all occurrences.
                        // Staff is guest/unauthenticated and the route is restricted to guests.
                        elseif ( $guest && 'guest-only' == $appRoute->permission->name ) {
                            $authorized = true;
                        }
                        // TODO: Get 'basic-authenticated' role name from config, and replace all occurrences.
                        // The route is available to any authenticated staff.
                        elseif ( !$guest && isset($staff) && ($staff->enabled) && 'basic-authenticated' == $appRoute->permission->name ) {
                            $authorized = true;
                        }
                        // The staff has the permission required by the route.
                        elseif ( !$guest && isset($staff) && ($staff->enabled) && $staff->can($appRoute->permission->name) ) {
                            $authorized = true;
                        }
                        // If all checks fail, abort with an HTTP 403 error.
                        else {
                            Log::error("Authorization denied for request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "], guest [" . $guest . "], username [" . $staffname . "].");
                            $errorCode = 403;
                        }
                    }
                    // If all checks fail, abort with an HTTP 403 error.
                    else {
                        Log::error("No permission set for the requested route, path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "], guest [" . $guest . "], username [" . $staffname . "].");
                        $errorCode = 403;
                    }
                }
                // If application route is not found
                else {
                    Log::error("No application route found in AuthorizeRoute module for request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "].");
                    $errorCode = 403;
                } // if ( isset($appRoute) )
//                }
//                else
//                {
//                    return redirect( route('logout') );
//                }
            }
        }

        // If authorize, proceed
        if ($authorized) {
            return $next($request);
        // Else if error code was set abort with that.
        } elseif ( 0 != $errorCode ) {
            if ( !$guest && isset($staff) && (!$staff->enabled) ) {
                Log::error("Staff [" . $staff->username . "] disabled, forcing logout.");
                return redirect( route('logout') );
            }
            else {
                abort($errorCode);
            }
        // Lastly Fallback to error HTTP 500: Internal server error. We should not get to this!
        } else {
            Log::error("Server error while trying to authorize route, request path [" . $request->path() . "], method [" . $method . "] and action name [" . $actionName . "].");
            abort(500);
        }
    }

}
