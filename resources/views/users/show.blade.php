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
            <div class="card" >
                <div class="card-body">
                    <p>暂无数据</p>
                </div>
            </div>
        </div>
    </div>
@stop
