<?php

namespace App\Http\Controllers\Client\helpdesk;

// controllers
use App\Http\Controllers\Common\SettingsController;
use App\Http\Controllers\Controller;
// requests
use Modules\Tickets\Models\TicketThread;
// models
use Modules\Core\Models\Ticket\Tickets;
use Modules\Core\Models\Staff;
use Auth;
// classes
use Exception;
use Illuminate\Http\Request;
use Input;

/**
 * TicketController2.
 *
 * @author        Ladybird <info@ladybirdweb.com>
 */
class ClientTicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return type response
     */
    public function __construct()
    {
        SettingsController::smtp();
        // //$this->middleware('auth');
        // $this->middleware('role.user');
    }

    /**
     * Get Checked ticket.
     *
     * @param type Tickets $ticket
     * @param type User    $user
     *
     * @return type response
     */
    public function getCheckTicket(Tickets $ticket, User $user)
    {
        return view('themes.default1.client.helpdesk.guest-user.newticket', compact('ticket'));
    }

    /**
     * reply.
     *
     * @param type $value
     *
     * @return type view
     */
    public function reply($id, Request $request)
    {
        $comment = $request->input('comment');
        if ($comment != null) {
            $tickets = Tickets::where('id', '=', $id)->first();
            $tickets->closed_at = null;
            $tickets->closed = 0;
            $tickets->reopened_at = date('Y-m-d H:i:s');
            $tickets->reopened = 1;
            $tickets->isanswered = 0;
            $threads = new Ticket_Thread();
            $threads->user_id = Auth::guard('staff')->user()->id;
            $threads->ticket_id = $tickets->id;
            $threads->poster = 'client';
            $threads->body = $comment;
            try {
                $threads->save();
                $tickets->save();

                return \Redirect::back()->with('success1', 'Successfully replied');
            } catch (Exception $e) {
                return \Redirect::back()->with('fails1', $e->errorInfo[2]);
            }
        } else {
            return \Redirect::back()->with('fails1', 'Please fill some data!');
        }
    }
}
