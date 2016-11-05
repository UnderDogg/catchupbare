<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Repositories\AuditRepository as Audit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var Audit
     */
    protected $audit;

    /**
     * @var App
     */
    protected $app;

    protected $context;

    protected $context_help_area;

    public function __construct(Application $app, Audit $audit, $context = null)
    {
        $this->app = $app;
        $this->audit = $audit;
        $this->context = $context;
        $this->context_help_area = '';

        if ((new Setting())->get('app.context_help_area')) {
            $this->context_help_area = View::make('core::context_help.disabled')->render();
        }
        View::share('context_help_area', $this->context_help_area);
    }


}
