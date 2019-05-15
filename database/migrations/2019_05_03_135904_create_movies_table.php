<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('Mid')->comment("電影ID");
            $table->string('Name', 64)->comment("片名");
            $table->string('Name_en', 64)->comment("英文片名");
            $table->date('Ondate')->comment("上映時間");
            $table->string('Type', 12)->comment("類型");
            $table->string('Length', 12)->comment("片長");
            $table->integer('Grade')->comment("分級");
            $table->text('Director')->comment("導演");
            $table->text('Actor')->comment("演員");
            $table->text('Poster')->comment("海報");
            $table->text('Introduction')->comment("劇情簡介");
            $table->integer('Display')->comment("前台顯示")->default(1);
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
        Schema::dropIfExists('movies');
    }
}
