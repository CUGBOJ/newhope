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
            $table->string('Title', 100)->unique();

            $table->text('Description')->nullable();
            $table->text('Input')->nullable();
            $table->text('Output')->nullable();
            $table->text('Sample_input')->nullable();
            $table->text('Sample_output')->nullable();
            $table->text('Hint')->nullable();


            $table->string('Author', 100)->nullable();

            $table->integer('Time_limit')->nullable();
            $table->integer('Hide')->default(0);// 3 state for 0.not hide 1.hide 2.used in contest
            $table->integer('Memory_limit')->nullable();
            $table->integer('AC_number')->nullable();
            $table->integer('Submit_number')->nullable();
            $table->integer('AC_user_number')->nullable();
            $table->integer('Submit_user_number')->nullable();
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
