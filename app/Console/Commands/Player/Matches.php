<?php

namespace App\Console\Commands\Player;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use App\Player;
use App\Services\Match;

class Matches extends Command
{

    /**
     *  The name and signature of the console command.
     *
     *  @var string
     */
    protected $signature    =   'player:matches {player}';

    /**
     *  The console command description.
     *
     *  @var string
     */
    protected $description  =   'Import summoner matches from the League of Legends API';

    /**
     *  Execute the console command.
     *
     *  @return mixed
     */
    public function handle ()
    {

        $v = Validator::make ( $this->arguments () , [
            "player" => [ "required" , "exists:players,id" ],
        ]);

        if ( $v->fails () ) { return; }

        $player =   Player::findOrFail ( $this->argument ( "player" ) );

        $data   =   Match::getPlayerMatches ( $player );

        foreach ( $data->matches as $match )
        {

            dispatch (
                new \App\Jobs\GetMatch ( $match->gameId , $player->region ) );

            return;

        }

    }

}
