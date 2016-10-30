<?php
namespace Modules\Knowledgebase\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('staff');
    }

    public function admindashboard()
    {
        return view('knowledgebase::kb.kbdashboard');
    }


}