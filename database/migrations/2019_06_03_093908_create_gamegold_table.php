<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamegoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamegold', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('Uid')->comment("帳號ID");
            $table->decimal('Gold', 10, 4)->unsigned()->comment("遊戲額度");
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
        Schema::dropIfExists('gamegold');
    }
}
