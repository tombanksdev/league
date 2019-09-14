<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     *  Run the migrations.
     *
     *  @return void
     */
    public function up ()
    {

        Schema::create ( 'games' , function ( Blueprint $table ) {

            $table->bigIncrements ( 'id' );

            $table->string ( 'game_id' )->unique ();
            $table->string ( 'game_unique' )->unique ();

            $table->string ( 'region' );

            $table->integer ( 'queue' );
            $table->integer ( 'season' );

            $table->dateTime ( 'played_at' );

            $table->timestamps ();

        });

    }

    /**
     *  Reverse the migrations.
     *
     *  @return void
     */
    public function down ()
    {

        Schema::dropIfExists ( 'games' );

    }

}
