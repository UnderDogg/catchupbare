<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Models\Comment;
use Illuminate\Http\Request;
use Auth;
use Session;
use Modules\Core\Models\Ticket;

class CommentController extends Controller
{
    public function store(Request $commentRequest, $id)
    {
        $this->validate($commentRequest, [
            'description' => 'required',
            'fk_ticket_id' => '',
            'fk_staff_id' => '']);

        $input = $commentRequest = array_merge(
            $commentRequest->all(),
            ['fk_ticket_id' => $id, 'fk_staff_id' => \Auth::id()]
        );
        Comment::create($input);
        Session::flash('flash_message', 'Comment successfully added!'); //Snippet in Master.blade.php
        return redirect()->back();
    }
}
