<?php

namespace App\Http\Middleware;

use App\Libraries\Utils;
use Closure;
use Theme;

class ThemeSelector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $themeName = Utils::getStaffOrAppOrDefaultSetting('theme', 'theme.default', 'default');

        Theme::init( $themeName );

        return $next($request);
    }

}
