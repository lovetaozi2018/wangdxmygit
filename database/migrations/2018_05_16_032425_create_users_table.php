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
            $table->increments('id');
            $table->string('username', 64)->unique()->comment('用户名或账号');
            $table->string('realname')->comment('真实姓名');
            $table->integer('role_id')->comment('所属角色/权限ID');
            $table->string('password', 60)->comment('密码');
            $table->string('remember_token')->nullable()->comment('"记住我"令牌，登录时用');
            $table->boolean('gender')->comment('性别');
            $table->char('mobile', 11)->unique()->nullable()->comment('手机号码');
            $table->string('phone')->nullable()->comment('座机');
            $table->string('qq')->nullable()->comment('qq');
            $table->string('wechat')->nullable()->comment('微信账号');
            $table->string('qrcode_image')->nullable()->comment('头像URL');
            $table->string('ground_image')->nullable()->comment('背景图');
            $table->integer('school_id')->nullable()->comment('学校id');
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
        Schema::dropIfExists('users');
    }
}
