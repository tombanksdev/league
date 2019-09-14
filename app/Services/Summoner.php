<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class Summoner extends Facade
{

    /**
     *  Get the facade bind name
     * 
     *  @return string
     */
    public static function getFacadeAccessor ()
    {

        return "tb-summoner";

    }

}