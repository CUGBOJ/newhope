<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id', 1);
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->text('sample_input')->nullable();
            $table->text('sample_output')->nullable();
            $table->text('hint')->nullable();
            $table->text('source')->nullable();
            $table->string('v_name')->default('CUGB');
            $table->string('author', 100)->nullable();
            $table->boolean('hide')->default(0);

            $table->boolean('special_judge')->default(0);
            $table->unsignedInteger('time_limit')->default(1000);
            $table->unsignedInteger('case_time_limit')->default(1000);
            $table->unsignedInteger('memory_limit')->default(0);
            $table->unsignedInteger('total_ac')->default(0);
            $table->unsignedInteger('total_submit')->default(0);
            $table->unsignedInteger('total_ac_user')->default(0);
            $table->unsignedInteger('total_submit_user')->default(0);
            $table->unsignedInteger('total_wa')->default(0);
            $table->unsignedInteger('total_re')->default(0);
            $table->unsignedInteger('total_ce')->default(0);
            $table->unsignedInteger('total_tle')->default(0);
            $table->unsignedInteger('total_mle')->default(0);
            $table->unsignedInteger('total_pe')->default(0);
            $table->unsignedInteger('total_ole')->default(0);
            $table->unsignedInteger('total_rf')->default(0);
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
