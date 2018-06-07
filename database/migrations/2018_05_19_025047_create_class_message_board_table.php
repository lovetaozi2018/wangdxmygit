<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassMessageBoardTable extends Migration
{
    /**
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_message_board', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id')->comment('班级id');
            $table->integer('student_id')->comment('学生id');
            $table->text('content')->comment('留言内容');
            $table->integer('hints')->default(0)->comment('点击量');
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
        Schema::dropIfExists('class_message_board');
    }
}
