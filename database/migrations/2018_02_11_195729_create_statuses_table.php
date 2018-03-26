<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->integer('id', 1);
            $table->string('username')->index('username');
            $table->integer('pid')->index('pid');
            $table->integer('contest_belong')->nullable()->default(null);
            $table->string('result');
            $table->integer('time')->nullable();
            $table->integer('memory')->nullable();
            $table->integer('length')->default(0);
            $table->integer('lang');
            $table->timestamp('submit_time');
            $table->text('code');
            $table->boolean('be_judged')->default(false);
            $table->text('ce_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
