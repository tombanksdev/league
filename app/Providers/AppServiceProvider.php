<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     *  Register any application services.
     *
     *  @return void
     */
    public function register () {}

    /**
     *  Bootstrap any application services.
     *
     *  @return void
     */
    public function boot ()
    {
        
        $this->app->bind ( "tb-match" , "App\\Services\\MatchService" );
        $this->app->bind ( "tb-summoner" , "App\\Services\\SummonerService" );

    }

}
