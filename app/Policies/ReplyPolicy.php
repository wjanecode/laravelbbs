<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return $user->isAuthorOf($reply);

    }

    public function destroy(User $user, Reply $reply)
    {
        //文章作者或者回复的作者可以删除回复
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->post);

    }
}
