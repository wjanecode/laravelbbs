<div>
    <ul class="media-list reply-ul" >
        @foreach($replies as $reply)
        <li class="media reply-list">
            <div class="media-left">
                {{--点击图片进入用户,可以查看用户所有帖子和回复--}}
                <a href="{{ route('users.show',[$reply->user->id,'tab'=>'replies']) }}">
                    <img class="media-object reply-avatar" src="{{ asset($reply->user->avatar) }}" alt="" >
                </a>
            </div>
            <div class="media-body">
                <div>
                    <strong> <a href="{{ route('users.show',[$reply->user->id,'tab'=>'replies']) }}">{{$reply->user->name}} </a></strong> -- <span>{{$reply->created_at->diffForHumans()}}</span>
                    <div><a href="{{ route('posts.show',[$reply->post_id,'#replies'.$reply->id]) }}"></a></div>
                    <div style="float: right">
                        @can('destroy',$reply)
                        <form action="{{ route('replies.destroy', $reply->id) }}"
                              method="post"
                              style="display: inline-block;"
                              onsubmit="return confirm('您确定要删除吗？');">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="far fa-trash-alt"></i> 删除
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>


                {{--原格式输出,允许HTML,在保存数据时做过滤--}}
               {!! $reply->content !!}


            </div>
        </li>
        @endforeach

    </ul>
    {{-- 分页 携带请求的数据,先排除page参数--}}
    <div class="mt-4 pt-1">
        {!! $replies->appends(Request::except('page'))->render() !!}
    </div>

</div>
