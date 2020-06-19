@extends('layouts.app')
@section('style')
    {{--editor css--}}
    <link rel="stylesheet" href="{{ asset('css/simditor.css') }}">
@stop

@section('js')
    {{--editor js注意顺序--}}
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('posts.upload_image') }}',//上传图片url
                    params: {
                        _token: '{{ csrf_token() }}',//单提交的参数，Laravel 的 POST 请求必须带防止 CSRF 跨站请求伪造的 _token 参数；
                    },
                    fileKey: 'upload_file',//是服务器端获取图片的键值，我们设置为 upload_file;
                    connectionCount: 3,//最多只能同时上传 3 张图片；
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'//上传过程中，用户关闭页面时的提醒。
                },
                pasteImage: true,//设定是否支持图片黏贴上传，这里我们使用 true 进行开启
            });

        });
    </script>
@stop
@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          发帖 /
          @if($post->id)
            编辑 #{{ $post->id }}
          @else
            新建
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($post->id)
          <form action="{{ route('posts.update', $post->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('posts.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                	<label for="title-field">标题</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $post->title ) }}" />
                </div>
              <div class="form-group">
                  <label for="category_id-field">选择分类</label>

                  <select class="form-control" name="category_id" id="">
                      @foreach($categories as $cate)
                          <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                      @endforeach
                  </select>
              </div>
                <div class="form-group">
                	<label for="body-field">内容</label>
                    <textarea name="body" id="editor" class="form-control">{{ old('body', $post->body ) }}</textarea>
                </div>



          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">保存</button>
            <a class="btn btn-link float-xs-right" href="{{ route('posts.index') }}"> <- 返回</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
