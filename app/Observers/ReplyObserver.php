<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{

    public function saving(Reply $reply)
    {
        // XSS 过滤,使用默认配置
        $reply->content = clean($reply->content, 'default');

    }

    public function saved(Reply $reply) {
        //帖子重新统计回复数
        $reply->post->updateRepliesCount();

    }

    public function deleted(Reply $reply) {

        //帖子重新统计回复数
        $reply->post->updateRepliesCount();
    }
}
