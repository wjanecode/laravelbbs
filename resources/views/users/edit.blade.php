@extends('layouts.app')
@section('title','修改信息')
@section('content')
    <div class="row justify-content-center">
        <form class="form col-md-6" action="{{ route('users.update',$user->id) }}" method="POST">
            {{ csrf_field() }}
            {{--PUT方法不能直接写在form那里,要先写POST,再在下面补充为PUT            --}}
            <input type="text" hidden name="_method" value="PUT">
            <div class="form-group">
                <label for="">用户名</label>
                <input
                    type="text"
                    name="name" id="name" class="form-control" value="{{ $user->name }}" required aria-describedby="helpId">
            </div>
            <div class="form-group">
                <label for="">邮箱</label>
                <input
                    type="email"
                    name="email" id="email" class="form-control" value="{{ $user->email }}" required aria-describedby="helpId">
            </div>
            <div class="form-group">
                <label for="">个人简介</label>
                <textarea
                    type="text"
                    name="introduce" id="introduce" class="form-control">{{ $user->introduce }}</textarea>
            </div>
            <div class="form-group"style="text-align: center">
                <button type="submit"  class="btn btn-primary">提交</button>
            </div>
        </form>

    </div>
@stop
@section('js')

@stop
