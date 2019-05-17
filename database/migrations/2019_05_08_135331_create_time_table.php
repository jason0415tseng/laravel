<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time', function (Blueprint $table) {
            $table->bigIncrements('Tid')->comment("時刻ID");;
            $table->integer('Mid')->comment("電影ID");
            $table->string('Hall', 64)->comment("廳別");
            $table->string('Date', 64)->comment("時刻");
            $table->smallinteger('Seat')->unsigned()->comment("張數");
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
        Schema::dropIfExists('time');
    }
}
