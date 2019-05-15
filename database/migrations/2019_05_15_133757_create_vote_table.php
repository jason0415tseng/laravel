<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote', function (Blueprint $table) {
            $table->bigIncrements('Vid')->comment("投票ID");
            $table->integer('VoteAid')->comment("活動ID");
            $table->integer('VoteACid')->comment("內容ID");
            $table->string('VoteAccount', 64)->comment("投票者");
            $table->string('VoteIp', 64)->comment("投票者ip");
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
        Schema::dropIfExists('vote');
    }
}
