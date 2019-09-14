<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{

    /**
     *  Run the migrations.
     *
     *  @return void
     */
    public function up ()
    {

        Schema::create ( 'players' , function ( Blueprint $table ) {

            $table->bigIncrements ( 'id' );

            $table->string ( 'player_unique' )->unique ();

            $table->string ( 'name' );
            $table->string ( 'account_id' )->unique ();            

            $table->string ( 'region' );

            $table->integer ( 'thumbnail' );

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

        Schema::dropIfExists ( 'players' );

    }

}
