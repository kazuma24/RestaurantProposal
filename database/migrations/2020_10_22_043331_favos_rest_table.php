<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FavosRestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('favoRests', function (Blueprint $table) {
            $table->id();
            $table->string('restId');
            $table->string('restName');
            $table->string('restImage');
            $table->string('restUrl');
            $table->string('restFlag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('favoRests');
    }
}
