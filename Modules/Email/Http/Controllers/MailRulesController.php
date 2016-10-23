<?php
namespace Modules\Email\Http\Controllers;


use App\Http\Requests;

// controllers
use App\Http\Controllers\Controller;

// requests
use Modules\Email\Services\MailRuleServiceContract;

// models
use Modules\Email\Models\MailRule;
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
 * MailRulesController
 * In this controller in the CRUD function for all the banned emails.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class MailRulesController extends Controller
{

    protected $mailrules;

    public function __construct(MailRuleServiceContract $mailrules)
    {
        $this->mailrules = $mailrules;
        //$this->middleware('staff');
        //$this->middleware('user.is.admin', ['only' => ['create', 'destroy']]);
    }

    public function index()
    {
        return view('email::mailrules.index')
            ->withmailrules($this->mailrules->getAllMailRules());
    }


    public function anyData()
    {
        //$canUpdateStaff = auth()->user()->can('update-user');
        //Auth::guard($guard)->user()->can('update-user');
        $mailrules = MailRule::select(['id', 'mailrule', 'updated_at']);
        return Datatables::of($mailrules)

            ->addColumn('mailrule', function ($mailrules) {
                return '<a href="/mailpanel/mailrules/' . $mailrules->id . '" ">' . $mailrules->mailrule . '</a>';
            })
            ->addColumn('lastupdate', function ($mailrules) {
                return '<a href="/mailpanel/mailrules/' . $mailrules->id . '" ">' . $mailrules->updated_at . '</a>';
            })

            ->addColumn('actions', function ($mailrules) {
                return '
                <form action="' . route('mailrules.destroy', [$mailrules->id]) .'" method="POST">
                <div class=\'btn-group\'>
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('mailrules.edit', [$mailrules->id]) . '" class=\'btn btn-success btn-xs\'>Edit</a>
                    <input type="submit" name="submit" value="Delete" class="btn btn-danger btn-xs" onClick="return confirm(\'Are you sure?\')"">
                </div>
                </form>';
            })
            ->make(true);
    }


    public function create()
    {
        return view('mailrules.create');
    }

    public function store(StoreMailRuleRequest $request)
    {
        $this->mailrules->create($request);
        Session::flash('flash_message', 'Successfully created New MailRule');
        return redirect()->route('mailrules.index');
    }

    public function destroy($id)
    {
        $this->mailrules->destroy($id);
        return redirect()->route('mailrules.index');
    }
}
