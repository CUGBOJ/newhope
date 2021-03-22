<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id', 1);
            $table->string('username')->index('username');
            $table->integer('problem_id')->index('problem_id');
            $table->string('title');
            $table->text('body');
            $table->integer('reply_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('last_reply_username');
            $table->integer('order')->default(0);
            $table->integer('contest_id')->index('cid')->nullable()->default(null);
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
        Schema::dropIfExists('topics');
    }
}
