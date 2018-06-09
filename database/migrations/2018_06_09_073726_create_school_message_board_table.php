<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolMessageBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_message_board', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_video_id')->comment('视频id');
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
        Schema::dropIfExists('school_message_board');
    }
}
