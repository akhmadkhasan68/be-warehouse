<?php

namespace App\Providers;

use App\Macros\Builder\WhereOrWhere;
use Illuminate\Support\ServiceProvider;

class WhereOrWhereMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make(WhereOrWhere::class);
    }
}
