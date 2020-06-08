<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypePrizesTableAddMultiplicator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_prizes', function (Blueprint $table) {
            $table->decimal('multiplicator')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_prizes', function (Blueprint $table) {
            $table->dropColumn('multiplicator');
        });
    }
}
