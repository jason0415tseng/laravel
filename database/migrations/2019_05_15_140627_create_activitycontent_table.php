<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitycontentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitycontent', function (Blueprint $table) {
            $table->bigIncrements('ACid')->comment("內容ID");
            $table->integer('Aid')->comment("活動ID");
            $table->text('Content')->comment("內容");
            $table->integer('VoteNumber')->comment("投票數")->default(0);
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
        Schema::dropIfExists('activitycontent');
    }
}
