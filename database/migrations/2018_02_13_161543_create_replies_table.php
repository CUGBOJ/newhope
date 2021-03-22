<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepliesTable extends Migration
{
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id', 1);
            $table->integer('topic_id')->index();
            $table->string('username')->index();
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
