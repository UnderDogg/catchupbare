<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;



class DashboardController extends Controller
{

    public function index() {

        $page_title = "Dashboard";
        $page_description = "This is the dashboard";

        return view('core::admin.admindashboard', compact('page_title', 'page_description'));
    }

}
