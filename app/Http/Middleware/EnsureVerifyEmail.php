<?php

namespace App\Http\Middleware;

use Closure;

/**
 * 邮箱验证中间件
 * Class EnsureVerifyEmail
 * @package App\Http\Middleware
 */
class EnsureVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //三个验证
        //用户已登录
        //并且未验证邮箱
        //并且访问的不是验证url和logout
        if($request->user() &&
        !$request->user()->hasVerifiedEmail() &&
        !$request->is('email/*','logout')){

            return $request->expectsJson()
                ? abort('403','你的邮箱还没验证')//json信息
                : redirect()->route('verification.notice');//邮箱验证提示界面
        }

        return $next($request);
    }
}
