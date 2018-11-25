<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamApplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_apply', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('team_id');
            $table->boolean('be_deal')->default(false);
            $table->timestamp('deal_time')->nullable();
            $table->timestamp('create_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_apply');
    }
}
