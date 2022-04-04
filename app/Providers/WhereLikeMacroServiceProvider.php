<?php

namespace App\Providers;

use App\Macros\Builder\WhereLikeMacros;
use Illuminate\Support\ServiceProvider;

class WhereLikeMacroServiceProvider extends ServiceProvider
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
        $this->app->make(WhereLikeMacros::class);
    }
}
