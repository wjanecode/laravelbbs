<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

/**
 * 记录用户每次访问,每次请求,记录用户最后登录时间
 * 先保存到redis,
 * Class RecordLastActive
 * @package App\Http\Middleware
 */
class RecordLastActive
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
        //前置中间件
        //如果是登录用户
        if(\Auth::check()){
            //记录最后登录时间
            //调用user的trait
            \Auth::user()->recordLastActiveTime();
        }


        return $next($request);
    }
}
