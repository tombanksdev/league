<?php

namespace App\Services;

use GuzzleHttp\Client;

class SummonerService
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
     *  Get summoner by id
     * 
     *  @param  string      $id
     *  @param  string      $region
     *  @return mixed
     */
    public function getSummonerById ( $id , $region = "euw" )
    {

        $response = $this->http->get ( "https://{$region}.api.riotgames.com/lol/summoner/v4/summoners/by-account/{$id}" ,
            [
                "headers" => [
                    "X-Riot-Token"  =>  config ( "services.league.key" ),
                ],
            ]
        );

        return json_decode ( $response->getBody () );

    }

    /**
     *  Get a summoner by name
     * 
     *  @param  string      $name
     *  @param  string      $region
     *  @return mixed
     */
    public function getSummonerByName ( $name , $region = "euw" )
    {

        $response = $this->http->get ( "https://{$region}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{$name}" ,
            [
                "headers" => [
                    "X-Riot-Token"  =>  config ( "services.league.key" ),
                ],
            ]
        );

        return json_decode ( $response->getBody () );

    }

}