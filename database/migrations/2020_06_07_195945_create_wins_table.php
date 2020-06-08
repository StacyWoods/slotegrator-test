<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('value')->default(1);
            $table->bigInteger('status_id');
            $table->bigInteger('user_id');
            $table->bigInteger('type_prize_id');
            $table->bigInteger('goods_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('wins', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_prize_id')->references('id')->on('type_prizes');
            $table->foreign('goods_id')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wins');
    }
}
