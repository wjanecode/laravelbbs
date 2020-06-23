<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\PostReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply  ) {
        //帖子重新统计回复数
        $reply->post->updateRepliesCount();

        //向作者发送回复通知
        $user = $reply->post->user;
        $user->notify(new PostReplied($reply));
        //通知数量加一
        $user->increment('notification_count');
        $user->save();

    }

    public function saving(Reply $reply)
    {
        // XSS 过滤,使用默认配置
        $reply->content = clean($reply->content, 'default');

    }



    public function deleted(Reply $reply) {

        //帖子重新统计回复数
        $reply->post->updateRepliesCount();
    }
}
