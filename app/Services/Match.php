<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class Match extends Facade
{

    /**
     *  Get the facade bind name
     * 
     *  @return string
     */
    public static function getFacadeAccessor ()
    {

        return "tb-match";

    }

}