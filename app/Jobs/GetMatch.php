<?php

namespace App\Jobs;

use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Game;
use App\Kill;
use App\Player;

use App\Services\Match;

class GetMatch implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     *  The game id
     *  
     *  @var int
     */
    protected $id;

    /**
     *  The region name
     *  
     *  @var string
     */
    protected $region;

    /**
     *  Create a new job instance.
     *
     *  @param  int         $id
     *  @param  string      $region
     *  @return void
     */
    public function __construct ( $id , $region )
    {

        $this->id       =   $id;

        $this->region   =   $region;
        
    }

    /**
     *  Execute the job.
     *
     *  @return void
     */
    public function handle ()
    {

        if ( Game::where ( "game_id" , $this->id )->exists () ) { return; }

        /**
         *  Get the game information
         */

        $data   =   Match::getMatchById ( $this->id , $this->region );

        $game   =   Game::updateOrCreate ([
            "game_unique"   =>  "{$this->region}.{$this->id}",
        ] , [
            "game_id"       =>  $this->id,
            "region"        =>  $this->region,
            "queue"         =>  $data->queueId,
            "season"        =>  $data->seasonId,
            "played_at"
                => Carbon::createFromTimestamp (
                    floor ( $data->gameCreation / 1000 )
                ),
        ]);

        $players    =   [];

        foreach ( $data->participants as $participant )
        {

            $players [ $participant->participantId ] = [
                "lane"      =>  strtolower ( $participant->timeline->lane ),
                "role"      =>  strtolower ( $participant->timeline->role ),
                "champion"  =>  $participant->championId,

                "accountId" =>  ( function ( $id ) use ( $data ) {
                    $account = null;

                    foreach ( $data->participantIdentities as $identity )
                    {
                        if ( $identity->participantId == $id )
                        {
                            $account = $identity->player->accountId;
                        }
                    }

                    return $account;
                } ) ( $participant->participantId ),
            ];

        }

        foreach ( $players as $player )
        {

            $p
                = Player::query ()
                    ->where ( "region" , $this->region )
                    ->where ( "account_id" , $player [ 'accountId' ] )
                    ->first ();
            
            if ( $p )
            {
                $game->players ()->attach ( $p , [
                    "lane"      =>  $player [ 'lane' ],
                    "role"      =>  $player [ 'role' ],
                    "champion"  =>  $player [ 'champion' ],
                ]);
            }
            
        }

        /**
         *  Get the game timeline
         */

        $timeline = Match::getMatchTimelineById ( $this->id , $this->region );

        foreach ( $timeline->frames as $frame )
        {
            foreach ( $frame->events as $event )
            {
                if ( $event->type === "CHAMPION_KILL" )
                {
                    
                    $kill = Kill::updateOrCreate ([
                        "game_id"   =>  $game->id,
                        "killer_id" =>  $players [ $event->killerId ] [ 'accountId' ],
                        "victim_id" =>  $players [ $event->victimId ] [ 'accountId' ],
                        "killed_at" =>  $event->timestamp,
                    ] , [
                        "killer_champion"   =>  $players [ $event->killerId ] [ 'champion' ],
                        "victim_champion"   =>  $players [ $event->victimId ] [ 'champion' ],
                    ]);

                }
            }
        }

    }

}
