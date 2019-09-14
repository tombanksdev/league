<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{

    /**
     *  List of guarded attributes.
     * 
     *  @var array
     */
    protected $guarded = [];

    /**
     *  The game for this kill
     * 
     *  @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game ()
    {

        $this->belongsTo ( Game::class );

    }

}
