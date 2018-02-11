<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username')->index('username');
            $table->integer('pro_id')->index('pro_id');
            $table->string('title')->index('title');
            $table->text('body');
            $table->integer('reply_count')->index('reply_count')->default(0);
            $table->integer('view_count')->index('view_count')->default(0);
            $table->string('last_reply_username');
            $table->integer('order')->default(0);
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
