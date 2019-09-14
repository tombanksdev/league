<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePlayerTable extends Migration
{

    /**
     *  Run the migrations.
     *
     *  @return void
     */
    public function up ()
    {

        Schema::create ( 'game_player' , function ( Blueprint $table ) {

            $table->bigIncrements ( 'id' );

            $table->bigInteger ( 'game_id' )
                ->unsigned ();

            $table->string ( 'lane' )
                ->nullable ();

            $table->string ( 'role' )
                ->nullable ();

            $table->integer ( 'champion' )
                ->nullable ();

            $table->bigInteger ( 'player_id' )
                ->unsigned ();

            $table->timestamps ();

            /**
             *  Foreign Keys
             */

            $table->foreign ( 'game_id' )
                ->references ( 'id' )
                ->on ( 'games' )
                ->onDelete ( 'cascade' );

            $table->foreign ( 'player_id' )
                ->references ( 'id' )
                ->on ( 'players' )
                ->onDelete ( 'cascade' );

        });

    }

    /**
     *  Reverse the migrations.
     *
     *  @return void
     */
    public function down ()
    {
        
        Schema::dropIfExists ( 'game_player' );

    }

}
