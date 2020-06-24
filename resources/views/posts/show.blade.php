@extends('layouts.app')
@section('title',isset($category)? $category->name : '帖子')
@section('description',$post->excerpt)


@section('content')
    <div class="row">
        <div class="col-md-3">
            {{--左栏--}}

            <div class="card">
                <a href="{{ route('users.show',$post->user_id) }}">
                    <img class="card-img-top" src="{{asset($post->user->avatar)}}"  alt="头像">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><strong>作者简介</strong></h5>
                    <p class="card-text">{{ $post->user->introduce }}</p>
                    <h5><strong>加入时间</strong></h5>
                    <p>{{ $post->user->created_at->diffForHumans() }}</p>
                    <a name="" id="" class="btn btn-primary" href="{{ route('users.show',$post->user_id) }}"
                        role="button">查看作者</a>
                </div>
            </div>

        </div>
        {{--右栏--}}
        <div class="col-md-9 ">
            <div class="card ">
                <div class="card-header">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $post->title }}
                    </h1>
                    <div>
                        <div class="article-meta text-center text-secondary">
                            {{ $post->category->name }}
                            ·
                            {{ $post->created_at->diffForHumans() }}
                            ·
                            <i class="far fa-comment"></i>
                            {{ $post->reply_count }}
                        </div>
                        {{--权限判断 blade自带,授权策略判断用户是否能执行方法--}}
                        @can('destroy',$post)
                        <span>
                            <div class="operate" style="float: right">
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>
                               <form action="{{ route('posts.destroy', $post->id) }}"
                                     method="post"
                                     style="display: inline-block;"
                                     onsubmit="return confirm('您确定要删除吗？');">
                                   {{ csrf_field() }}
                                   {{ method_field('DELETE') }}
                                   <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="far fa-trash-alt"></i> 删除
                                   </button>
                               </form>

                        </div>
                        </span>
                        @endcan
                    </div>

                </div>
                <div class="card-body simditor-body">
                    {!! $post->body !!}
                </div>
            </div>
            {{--回复栏--}}
            <br/>
            <div class="card" >
                <div class="card-body">
                    <div class="reply">
                        {{--回复框--}}
                        <div >
                            @includeWhen(Auth::check(),'posts._reply_box',['post' => $post])
                        </div>
                        {{--回复列表--}}
                        <div >
                            @include('posts._reply_post_list',['replies' => $post->replies()->with('user')->recent()->paginate(10)])
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
