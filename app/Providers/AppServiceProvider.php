<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $access_menu =  DB::table('access')
                    ->join('menus', 'access.menu_id', '=', 'menus.id')
                    ->select('access.menu_id', 'menus.menu_key', 'access.status')
                    ->where('user_id',  Auth::user()->id)->get();

                $company = DB::table('companies')->get();
            } else {
                $access_menu = [];
                $company = DB::table('companies')->get();
            }

            $view->with(compact('access_menu', 'company'));
        });
    }
}
