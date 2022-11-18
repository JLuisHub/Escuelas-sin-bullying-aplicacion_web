<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $allHelperFiles = glob(app_path('Helpers') . '/*.php');
        foreach($allHelperFiles as $key => $helperfile){
            require_once $helperfile;
        }
    }

}
