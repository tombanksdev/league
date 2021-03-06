<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKillsTable extends Migration
{

    /**
     *  Run the migrations.
     *
     *  @return void
     */
    public function up ()
    {

        Schema::create ( 'kills' , function ( Blueprint $table ) {

            $table->bigIncrements ( 'id' );

            $table->string ( 'killer_id' );
            $table->string ( 'victim_id' );

            $table->integer ( 'killer_champion' )
                ->unsigned ();

            $table->integer ( 'victim_champion' )
                ->unsigned ();

            $table->bigInteger ( 'killed_at' )
                ->unsigned ();

            $table->bigInteger ( 'game_id' )
                ->unsigned ();

            $table->timestamps ();

            /**
             *  Foreign Keys
             */

            $table->foreign ( 'game_id' )
                ->references ( 'id' )
                ->on ( 'games' )
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

        Schema::dropIfExists ( 'kills' );

    }

}
