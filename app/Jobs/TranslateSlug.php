<?php

namespace App\Jobs;

use App\Handler\SlugTranslateHandler;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        //// 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->post->title);
        // 为了避免模型监控器死循环调用，使用 DB 类直接对数据库进行操作
        \DB::table('posts')->where('id', $this->post->id)->update(['slug' => $slug]);
    }
}
