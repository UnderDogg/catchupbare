<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Modules\Leads\Models\Lead;
use Modules\Core\Models\Note;

class NotesController extends Controller
{
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'note' => 'required',
            'status_id' => '',
            'fk_lead_id' => '',
            'fk_staff_id' => '']);

        $input = $request = array_merge(
            $request->all(),
            ['fk_lead_id' => $id, 'fk_staff_id' => \Auth::id(), 'status_id' => 0]
        );

        Note::create($input);
        Session::flash('flash_message', 'Note successfully added!'); //Snippet in Master.blade.php
        return redirect()->back();
    }
}
