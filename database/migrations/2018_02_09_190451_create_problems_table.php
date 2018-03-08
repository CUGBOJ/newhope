<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->integer('id',1);
            $table->string('title', 100)->unique();

            $table->text('description')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->text('sample_input')->nullable();
            $table->text('sample_output')->nullable();
            $table->text('hint')->nullable();

            $table->string('author', 100)->nullable();

            $table->boolean('hide')->default(0);

            $table->integer('time_limit')->nullable();
            $table->integer('memory_limit')->nullable();
            $table->integer('ac_number')->nullable();
            $table->integer('submit_number')->nullable();
            $table->integer('ac_user_number')->nullable();
            $table->integer('submit_user_number')->nullable();
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
        Schema::dropIfExists('problems');
    }
}
