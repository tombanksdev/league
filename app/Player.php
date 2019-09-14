<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    /**
     *  List of hidden attributes
     * 
     *  @var array
     */
    protected $hidden = [
        "player_unique"
    ];

    /**
     *  List of guarded attributes
     * 
     *  @var array
     */
    protected $guarded = [];

}
