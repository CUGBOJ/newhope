<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->integer('id',1);
            $table->string('Username')->index('username');
            $table->integer('Problem_id')->index('pro_id');
            $table->integer('Result');
            $table->integer('Time');
            $table->integer('Memory');
            $table->integer('Length');
            $table->integer('Lang');
            $table->timestamp('Submit_time');
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
