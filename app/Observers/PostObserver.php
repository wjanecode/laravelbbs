<?php

namespace App\Observers;

use App\Jobs\TranslateSlug;
use App\Models\Post;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class PostObserver
{
    public function saving(Post $post)
    {
        // XSS 过滤
        $post->body = clean($post->body, 'default');

        //生成摘录保存
        $post->excerpt = make_excerpt($post->body);

    }

    public function saved(Post $post) {
        // 使用翻译器对 title 进行翻译
        // 推送任务到队列 dispatch 调度
        dispatch( new TranslateSlug( $post ) );
    }

    public function deleted(Post $post) {

        //删除帖子,把关联的回复都删除
        \DB::table('replies')->where('post_id','=',$post->id)->delete();
    }


}
