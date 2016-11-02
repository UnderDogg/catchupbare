<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Libraries\SettingDotEnv;
use App\Libraries\Utils;
use App\Models\Setting;

use Modules\Core\Models\Company;
use App\Repositories\AuditRepository as Audit;

use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;



/**
 * CompaniesController.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Application $app, Audit $audit)
    {
        parent::__construct($app, $audit);
        // $this->smtp();
        //$this->middleware('auth');
        //$this->middleware('roles');
    }


    /**
     * @param int $id
     * @param $compant instance of company table
     *
     * get the form for company setting page
     *
     * @return Response
     */
    public function getcompany(Company $company)
    {
        try {
            /* fetch the values of company from company table */
            $companys = $company->whereId('1')->first();
            /* Direct to Company Settings Page */
            return view('core::admin.companies.company', compact('companys'));
        } catch (Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param type int            $id
     * @param type Company        $company
     * @param type CompanyRequest $request
     *
     * @return Response
     */
    public function postcompany($id, Company $company, CompanyRequest $request)
    {
        /* fetch the values of company request  */
        $companys = $company->whereId('1')->first();
        if (Input::file('logo')) {
            $name = Input::file('logo')->getClientOriginalName();
            $destinationPath = 'uploads/company/';
            $fileName = rand(0000, 9999).'.'.$name;
            Input::file('logo')->move($destinationPath, $fileName);
            $companys->logo = $fileName;
        }
        if ($request->input('use_logo') == null) {
            $companys->use_logo = '0';
        }
        /* Check whether function success or not */
        try {
            $companys->fill($request->except('logo'))->save();
            /* redirect to Index page with Success Message */
            return redirect('getcompany')->with('success', Lang::get('lang.company_updated_successfully'));
        } catch (Exception $e) {
            /* redirect to Index page with Fails Message */
            return redirect('getcompany')->with('fails', Lang::get('lang.company_can_not_updated').'<li>'.$e->getMessage().'</li>');
        }
    }
    /**
     * function to delete system logo.
     *
     *  @return type string
     */
    public function deleteLogo()
    {
        $path = $_GET['data1']; //get file path of logo image
        if (!unlink($path)) {
            return 'false';
        } else {
            $companys = Company::where('id', '=', 1)->first();
            $companys->logo = null;
            $companys->use_logo = '0';
            $companys->save();

            return 'true';
        }
        // return $res;
    }
}
