<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->comment('学校id');
            $table->string('title')->comment('视频名称');
            $table->string('image')->nullable()->comment('背景图');
            $table->string('path')->comment('视频路径');
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
        Schema::dropIfExists('school_videos');
    }
}
