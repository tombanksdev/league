<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    /**
     *  List of guarded attributes.
     * 
     *  @var array
     */
    protected $guarded = [];

    /**
     *  List of game kills.
     * 
     *  @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kills ()
    {
    
        return $this->hasMany ( Kill::class );

    }

    /**
     *  Players in this game.
     * 
     *  @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function players ()
    {

        return $this->belongsToMany ( Player::class );

    }

}
