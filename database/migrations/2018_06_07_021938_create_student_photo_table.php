<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPhotoTable extends Migration
{
    /**
     * 同学相册
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_photo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->comment('学生id');
            $table->string('path')->comment('图片路径');
            $table->boolean('enabled')->default(1);
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
        Schema::dropIfExists('student_photo');
    }
}
