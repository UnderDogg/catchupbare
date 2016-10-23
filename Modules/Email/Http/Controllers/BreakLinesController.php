<?php
namespace Modules\Email\Http\Controllers;


use App\Http\Requests;

// controllers
use App\Http\Controllers\Controller;

// requests
use Modules\Email\Requests\StoreBreakLineRequest;
use Modules\Email\Services\BreakLineServiceContract;

// models
use Modules\Email\Models\BreakLine;
use Modules\Core\Models\User;

//classes
use Illuminate\Http\Request;
use Session;
use Exception;
use Gate;
use Datatables;
use Carbon;
use PHPZen\LaravelRbac\Traits\Rbac;
use Illuminate\Support\Facades\Input;

/**
 * BreakLinesController
 * In this controller in the CRUD function for all the banned emails.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class BreakLinesController extends Controller
{

    protected $breaklines;

    public function __construct(BreakLineServiceContract $breaklines)
    {
        $this->breaklines = $breaklines;
        //$this->middleware('staff');
        //$this->middleware('user.is.admin', ['only' => ['create', 'destroy']]);
    }

    public function index()
    {
        return view('email::breaklines.index')
            ->withbreaklines($this->breaklines->getAllBreakLines());
    }


    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $breaklines = BreakLine::select(['id', 'breakline', 'isregexp', 'sortorder', 'updated_at']);
        return Datatables::of($breaklines)

            ->addColumn('breakline', function ($breaklines) {
                return '<a href="/mailpanel/breaklines/' . $breaklines->id . '" ">' . $breaklines->breakline . '</a>';
            })
            ->addColumn('lastupdate', function ($breaklines) {
                return '<a href="/mailpanel/breaklines/' . $breaklines->id . '" ">' . $breaklines->updated_at . '</a>';
            })

            ->addColumn('actions', function ($breaklines) {
                return '
                <form action="' . route('breaklines.destroy', [$breaklines->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('breaklines.edit', [$breaklines->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }


    public function create()
    {
        return view('breaklines.create');
    }

    public function store(StoreBreakLineRequest $request)
    {
        $this->breaklines->create($request);
        Session::flash('flash_message', 'Successfully created New BreakLine');
        return redirect()->route('breaklines.index');
    }

    public function destroy($id)
    {
        $this->breaklines->destroy($id);
        return redirect()->route('breaklines.index');
    }
}
