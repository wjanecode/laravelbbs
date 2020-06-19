<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy extends Policy
{
    public function update(User $user, Post $post)
    {
        // return $post->user_id == $user->id;//只有作者自己可以更新
        //在控制器中调用authorize()授权就行
        return $user->isAuthorOf($post);//封装了一下


    }

    public function destroy(User $user, Post $post)
    {

        //return $post->user_id === $user->id;//只有作者可以删除自己帖子
        return $user->isAuthorOf($post);//封装了一下
    }
}
