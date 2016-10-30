<?php

namespace Modules\Helpdesk\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// models
use Modules\Core\Models\Settings\System;
// classes
use Config;
use Redirect;

class WelcomepageController extends Controller
{
    /**
     * Display The main index.
     *
     * @return Response
     */
    public function index()
    {
        return view('helpdesk::helpdesk.guest-user.index');
    }

}