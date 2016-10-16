<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;



class DashboardController extends Controller
{

    public function index() {
        $data['tasks'] = [
            [
                'name' => 'Design New Dashboard',
                'progress' => '87',
                'color' => 'danger'
            ],
            [
                'name' => 'Create Home Page',
                'progress' => '76',
                'color' => 'warning'
            ],
            [
                'name' => 'Some Other Task',
                'progress' => '32',
                'color' => 'success'
            ],
            [
                'name' => 'Start Building Website',
                'progress' => '56',
                'color' => 'info'
            ],
            [
                'name' => 'Develop an Awesome Algorithm',
                'progress' => '10',
                'color' => 'success'
            ],
            [
                'name' => 'Analyse data',
                'progress' => '37',
                'color' => 'warning'
            ],
        ];

        $page_title = "Dashboard";
        $page_description = "This is the dashboard";

        return view('dashboard', compact('page_title', 'page_description'))->with($data);
    }

}
