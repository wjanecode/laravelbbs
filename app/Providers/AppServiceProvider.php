<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Reply;
use App\Observers\PostObserver;
use App\Observers\ReplyObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //只在开发环境中注册用户切换插件
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //解决 mysql 报错1071
        Schema::defaultStringLength(191);
        //注册模型观察者
        Post::observe(PostObserver::class);
        Reply::observe(ReplyObserver::class);
    }
}
