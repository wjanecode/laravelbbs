<?php

namespace App\Providers;

use App\Listeners\EmailVerified;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //注册完成事件监听
        Registered::class => [
            //发送注册邮箱
            SendEmailVerificationNotification::class,
        ],
        //验证事件监听
        Verified::class => [
            //邮箱验证成功消息
            EmailVerified::class,
        ],
        //密码重置成功事件监听
        PasswordReset::class => [
            //重置成功消息
            \App\Listeners\PasswordReset::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
