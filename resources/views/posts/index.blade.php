@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-9 ">
    <div class="card ">
      <div class="card-header">
        <h1>
          帖子
          <a class="btn btn-success float-xs-right" href="{{ route('posts.create') }}">新建</a>
        </h1>
      </div>

      <div class="card-body">

          <div class="card-header bg-transparent">
              <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#">最后回复</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">最新发布</a></li>
              </ul>
          </div>

          <ul class="media-list">
              {{--帖子列表--}}
              @include('posts._post_list')
          </ul>

          {{--页码--}}
          {!! $posts->render() !!}
      </div>
    </div>
  </div>
    <div class="col-md-3">
        {{--右侧导航--}}
        @include('posts._right_side')
    </div>
</div>



@endsection
