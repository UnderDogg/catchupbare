<?php

namespace Modules\Tickets\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'tickets');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'tickets');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerBindings();
    }


    private function registerBindings()
    {
        $this->app->bind('Modules\Tickets\Services\Ticket\TicketServiceContract', 'Modules\Tickets\Services\Ticket\TicketService');
        // add bindings
    }


}
