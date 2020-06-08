<?php

use App\Models\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type');

            $table->softDeletes();
            $table->timestamps();
        });

        $mustHaveStatuses = [
            'pending'       => 'common',
            'rejected'      => 'common',
            'transferred'   => 'money',
            'converted'     => 'money',
            'accepted'      => 'bonus',
            'sent'          => 'goods',
        ];

        collect($mustHaveStatuses)->each(function ($item, $key) {
            Status::create([
                'slug' => $key,
                'title' => $key,
                'type' => $item,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
