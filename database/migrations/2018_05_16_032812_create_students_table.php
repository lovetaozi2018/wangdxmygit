<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->integer('class_id')->comment('班级id');
            $table->string('duty',32)->nullable()->comment('职务');
            $table->string('star',32)->nullable()->comment('星座');
            $table->string('address')->nullable()->comment('住址');
            $table->string('hobby')->nullable()->comment('爱好');
            $table->string('specialty')->nullable()->comment('特长');
            $table->boolean('enabled');
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
        Schema::dropIfExists('students');
    }
}
