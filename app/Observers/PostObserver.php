<?php

namespace App\Observers;

use App\Models\Post;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class PostObserver
{
    public function creating(Post $post)
    {
        //生成摘录保存
        $post->excerpt = make_excerpt($post->body);

    }

    public function updating(Post $post)
    {
        //
    }
}
