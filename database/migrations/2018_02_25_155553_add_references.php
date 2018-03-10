<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferences extends Migration
{
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {

            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

        });

        Schema::table('replies', function (Blueprint $table) {

            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropForeign(['username']);
            $table->dropForeign(['problem_id']);
        });

        Schema::table('replies', function (Blueprint $table) {
            $table->dropForeign(['username']);
            $table->dropForeign(['topic_id']);
        });

    }
}