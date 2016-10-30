<?php

namespace Modules\Tickets\Http\Controllers;

// controllers
use App\Http\Controllers\Controller;
// models
use Modules\Tickets\Models\TicketPriority;
use Modules\Tickets\Models\TicketThread;
// classes
use Exception;

/**
 * ThreadController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ThreadController extends Controller
{
    /**
     * get the values from ticket_thread Table and direct to view page.
     *
     * @param type Ticket_thread $thread
     * @param type Priority      $priority
     *
     * @return type Response
     */
    public function getTickets(TicketThread $thread, TicketPriority $priority)
    {
        //try {
            /* get the values of Ticket_thread from Ticket_thread Table  */
            $threads = $thread->get();
            /* get the values of priority from Priority Table  */
            $priorities = $priority->get();
            /* Direct to view page */
            return view('tickets::tickets.ticket', compact('threads', 'priorities'));
        //} catch (Exception $e) {
        //    return view('errors.404');
        //}
    }
}
