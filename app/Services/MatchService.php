<?php

namespace App\Services;

use GuzzleHttp\Client;

use App\Player;

class MatchService
{

    /**
     *  The HTTP client.
     * 
     *  @var GuzzleHttp\Client
     */
    protected $http;

    /**
     *  The class constructor.
     * 
     *  @return void
     */
    public function __construct ()
    {

        $this->http = new Client ();

    }

    /**
     *  Get a match by id
     * 
     *  @param  int         $id
     *  @param  string      $region
     *  @return mixed
     */
    public function getMatchById ( $id , $region )
    {

        $response = $this->http->get ( "https://{$region}.api.riotgames.com/lol/match/v4/matches/{$id}" , 
            [
                "headers" => [
                    "X-Riot-Token" => config ( "services.league.key" ),
                ],
            ]
        );

        return json_decode ( $response->getBody () );
        
    }

    /**
     *  Get a match timeline by id
     * 
     *  @param  int         $id
     *  @param  string      $region
     *  @return mixed
     */
    public function getMatchTimelineById ( $id , $region )
    {

        $response = $this->http->get ( "https://{$region}.api.riotgames.com/lol/match/v4/timelines/by-match/{$id}" ,
            [
                "headers" => [
                    "X-Riot-Token" => config ( "services.league.key" ),
                ],
            ]
        );

        return json_decode ( $response->getBody () );

    }

    /**
     *  Get a list of player matches
     * 
     *  @param  App\Player  $player
     *  @return mixed
     */
    public function getPlayerMatches ( Player $player )
    {

        $response = $this->http->get ( "https://{$player->region}.api.riotgames.com/lol/match/v4/matchlists/by-account/{$player->account_id}" ,
            [
                "headers" => [
                    "X-Riot-Token" => config ( "services.league.key" ),
                ]
            ]
        );

        return json_decode ( $response->getBody () );

    }

}