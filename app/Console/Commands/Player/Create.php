<?php

namespace App\Console\Commands\Player;

use Illuminate\Console\Command;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Player;
use App\Services\Summoner;

class Create extends Command
{

    /**
     *  The name and signature of the console command.
     *
     *  @var string
     */
    protected $signature    =   'player:create {name} {--region=euw1}';

    /**
     *  The console command description.
     *
     *  @var string
     */
    protected $description  =   'Import a summoner from the League of Legends API';

    /**
     *  Execute the console command.
     *
     *  @return mixed
     */
    public function handle ()
    {

        $v = Validator::make ( array_merge (
            $this->options (),
            $this->arguments ()
        ) , [
            "name"      =>  [ "required" ],
            "region"    =>  [ Rule::in ([
                "ru", "kr", "br1",
                "oc1", "jp1", "na1",
                "eun1", "euw1", "tr1",
                "la1", "la2",
            ]) ],
        ]);

        if ( $v->fails () ) { return; }

        /**
         *  Create the player
         */

        $data   =   Summoner::getSummonerByName ( $this->argument ( "name" ) , $this->option ( "region" ) );

        $player =   Player::updateOrCreate ([
            "player_unique" =>  $this->option ( "region" ) . ".{$data->accountId}",
        ] , [
            "name"          =>  $data->name,
            "account_id"    =>  $data->accountId,
            "region"        =>  $this->option ( "region" ),
            "thumbnail"     =>  $data->profileIconId,
        ] );

        if ( $player->wasRecentlyCreated ) {
            $this->info ( "{$player->name} has been added." );
        } else {
            $this->info ( "{$player->name} has already been added." );
        }

    }

}
