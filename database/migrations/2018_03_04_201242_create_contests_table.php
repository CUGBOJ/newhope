<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->integer('id',1)->index();
            $table->timestamp('create_time')->useCurrent();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamp('lock_board_time')->nullable();

            $table->string('owner',255);
            $table->string('password',2048)->nullable();
            $table->string('title',255)->unique();

            $table->longText('description')->nullable();
            $table->boolean('isprivate')->default(0);//if private only user in table contest_user can view.
            $table->boolean('hide_other')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
