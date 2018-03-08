<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {

            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table  ->foreign('role_id')
                ->references('id')
                ->on('roles');


            $table  ->foreign('permission_id')
                ->references('id')
                ->on('permissions');

            $table->primary(['role_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }
}
