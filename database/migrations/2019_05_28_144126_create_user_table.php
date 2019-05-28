<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('Uid')->comment("會員ID");;
            $table->tinyInteger('Level')->comment("會員等級")->default(3);
            $table->string('Account', 64)->comment("會員帳號");
            $table->string('Password', 64)->comment("會員密碼");
            $table->string('Name', 32)->comment("會員名稱");
            $table->string('Freeze', 2)->comment("凍結/啟用")->default('Y');
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
        Schema::dropIfExists('user');
    }
}
