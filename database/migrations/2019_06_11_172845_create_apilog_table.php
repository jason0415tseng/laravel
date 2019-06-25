<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApilogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apilog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('_index', 32)->comment("_index");
            $table->string('_type', 16)->comment("_type");
            $table->string('_id', 32)->unique('_id')->comment("_id");
            $table->string('server_name', 32)->comment("server_name");
            $table->string('request_method', 6)->comment("request_method");
            $table->string('status', 6)->comment("status");
            $table->string('size', 12)->comment("size");
            $table->dateTime('timestamp')->comment("timestamp");
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
        Schema::dropIfExists('apilog');
    }
}
