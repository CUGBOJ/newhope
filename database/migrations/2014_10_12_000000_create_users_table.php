<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id',1);
            $table->string('nickname');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('password');
            $table->string('school');
            $table->timestamp('last_login_time');
            $table->ipAddress('last_login_ip')->default('1.1.1.1');
            $table->integer('submit')->default(0);
            $table->integer('solved')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
