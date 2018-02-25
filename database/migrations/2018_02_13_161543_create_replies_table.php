<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration 
{
	public function up()
	{
		Schema::create('replies', function(Blueprint $table) {
            $table->integer('id',1);
            $table->integer('topic_id')->index();
            $table->string('username')->index();
            $table->text('content');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('replies');
	}
}
