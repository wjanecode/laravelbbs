@extends('layouts.app')

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
                	<label for="body-field">内容</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $post->body ) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category_id-field">选择分类</label>

                    <select class="form-control" name="category_id" id="">
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
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
