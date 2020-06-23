@extends('layouts.app')

@section('title',Auth::user()->name.'的消息中心')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">我的消息</div>
                    <div class="card-body">

                        @if($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                @include('notifications._' . Str::snake(class_basename($notification->type)),['notification'=>$notification])
                            @endforeach
                        @else
                            <p>没有消息通知!</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop
