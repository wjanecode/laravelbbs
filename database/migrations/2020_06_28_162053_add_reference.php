<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts',function (Blueprint $table){
           //添加外键约束,删除用户时删除用户帖子
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('replies',function (Blueprint $table){
            //添加外键约束,删除用户时删除对应回复
            $table->foreign('user_id')->references('id')->on('users');
            //添加外键约束,删除帖子时删除对应回复
            $table->foreign('post_id')->references('id')->on('posts');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //移除外键约束
        Schema::table('posts',function (Blueprint $table){
           $table->dropForeign('user_id');
        });

        Schema::table('replies',function (Blueprint $table){
            $table->dropForeign('user_id');
            $table->dropForeign('post_id');
        });
    }
}
