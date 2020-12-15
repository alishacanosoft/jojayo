<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WebsiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->sensitiveCompose();
    }
    public function sensitiveCompose(){
        view()->composer('*', 'App\Http\ViewComposer\SensitiveComposer');
    }
}
