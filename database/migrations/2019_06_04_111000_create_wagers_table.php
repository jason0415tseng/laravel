<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('GameId', 32)->comment("注單ID");
            $table->integer('Uid')->comment("帳號ID");
            $table->string('Account', 64)->comment("會員帳號");
            $table->tinyInteger('BetNumber')->comment("下注號碼");
            $table->tinyInteger('Lottery')->comment("開獎號碼");
            $table->decimal('BetGold', 10, 4)->comment("下注金額");
            $table->decimal('WinGold', 10, 4)->comment("輸贏金額");
            $table->dateTime('BetTime')->comment("下注時間");
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
        Schema::dropIfExists('wagers');
    }
}
