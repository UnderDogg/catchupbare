<?php
namespace Modules\Tickets\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketsDashBoardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('staff');
    }

    public function ticketsdashboard()
    {
        return view('tickets::tickets.ticketsdashboard');
    }


    
/*
public function ticketsdashboard()
{
return view('tickets::tickets.ticketsdashboard');
}
*/    
   
}