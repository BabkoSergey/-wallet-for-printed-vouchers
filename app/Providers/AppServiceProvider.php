<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;
use App\Requests;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('WalletAdminPanel.*', function($view)
        {
            $poartals = Requests::where('status','pending')->count();
            $view->with('notis',['portal'=>$poartals]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
