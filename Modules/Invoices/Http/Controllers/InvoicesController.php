<?php
namespace Modules\Invoices\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Modules\Invoices\Models\Invoice;
use Modules\Relations\Models\Relation;
use Modules\Invoices\Services\Invoice\InvoiceServiceContract;
use Modules\Invoices\Services\Relation\RelationServiceContract;

class InvoicesController extends Controller
{

    protected $relations;
    protected $invoices;

    public function __construct(
        InvoiceServiceContract $invoices,
        RelationServiceContract $relations
    )
    {
        $this->invoices = $invoices;
        $this->relations = $relations;
        //$this->middleware('staff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->invoices->create('test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('invoices.show')
            ->withInvoice($this->invoices->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updatePayment(Request $request, $id)
    {
        $this->invoices->updatePayment($id, $request);
        return redirect()->back();
    }

    public function reopenPayment(Request $request, $id)
    {
        $this->invoices->reopenPayment($id, $request);
        return redirect()->back();
    }

    public function updateSentStatus(Request $request, $id)
    {
        $this->invoices->updateSentStatus($id, $request);
        return redirect()->back();
    }

    public function updateSentReopen(Request $request, $id)
    {
        $this->invoices->updateSentReopen($id, $request);
        return redirect()->back();
    }

    public function newItem($id, Request $request)
    {
        $this->invoices->newItem($id, $request);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
