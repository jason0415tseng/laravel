<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('Oid')->comment("訂票ID");;
            $table->string('OrderNumber', 64)->comment("訂票編號");
            $table->integer('OrderMid')->comment("訂票電影ID");
            $table->string('OrderHall', 64)->comment("訂票廳別");
            $table->string('OrderTime', 64)->comment("訂票時刻");
            $table->integer('OrderTicket')->comment("訂票數量");
            $table->string('OrderSeat', 64)->comment("訂票座位");
            $table->integer('OrderUid')->comment("訂購者ID");
            $table->string('OrderAccount', 64)->comment("訂購者");
            $table->string('OrderName', 64)->comment("訂購者名稱");
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
        Schema::dropIfExists('order');
    }
}
