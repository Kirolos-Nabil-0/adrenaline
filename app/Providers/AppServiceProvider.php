<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::if('admin',function(){
            $user=auth()->user();
            return $user&&$user->role=='admin';
        });
        Blade::if('instructor',function(){
            $user=auth()->user();
            return $user&&$user->role=='instructor';
        });
        Blade::if('dashboard',function(){
            $user=auth()->user();
            return $user&&($user->role=='instructor'||$user->role=='admin');
        });
    }
}
