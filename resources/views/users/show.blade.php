@extends('layouts.app')

@section('title',$user->name.'的个人中心')
@section('content')
    <div class="row">
        {{--用户信息--}}
        <div class="col-md-3">
           <div class="card">
             <img class="card-img-top" src="{{asset($user->avatar)}}"  alt="头像">
             <div class="card-body">
               <h5 class="card-title"><strong>个人简介</strong></h5>
               <p class="card-text">{{ $user->introduce }}</p>
               <h5><strong>加入时间</strong></h5>
                 <p>{{ $user->created_at->diffForHumans() }}</p>
               <h5><strong>最后活跃</strong></h5>
                 <p>{{ $user->last_active_at->diffForHumans() }}</p>

               @if(Auth::id() === $user->id)
               <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary">修改信息</a>
               @endif
             </div>
           </div>
        </div>
        {{--发布的内容--}}
        <div class="col-md-9">

            <div class="card" >
                <div class="card-body">
                    <h1 ><strong>{{ $user->name }} </strong>&nbsp;<em>{{ $user->email }}</em></h1>
                </div>
            </div>

            {{--用户帖子和回复--}}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link {{ active_class(if_query('tab', null)) }} bg-transparent" href="{{ route('users.show',$user->id) }}">Ta 的帖子</a></li>
                        <li class="nav-item"><a class="nav-link {{ active_class(if_query('tab','replies')) }}" href="{{ route('users.show',[$user->id,'tab'=>'replies']) }}">Ta 的回复</a></li>
                    </ul>
                    @if(if_query('tab','replies'))
                        {{--用户回复的帖子--}}
                        @include('users._reply_user_list',['replies'=>$user->replies()->with('post','user')->recent()->paginate(10)])
                    @else
                        {{--用户最新发布的帖子,可以模板内传参,重新构建查询语句--}}
                        @include('users._posts_list',['posts'=>$user->post()->recent()->paginate(10)])
                    @endif
                </div>
            </div>





        </div>
    </div>
@stop
