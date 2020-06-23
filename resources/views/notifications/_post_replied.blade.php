<li class="media @if ( ! $loop->last) border-bottom @endif">
    <div class="media-left">
        <a href="{{ route('users.show', $notification->data['user_id']) }}">
            <img class="media-object img-thumbnail mr-3" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}" style="width:48px;height:48px;" />
        </a>
    </div>

    <div class="media-body">
        <div class="media-heading mt-0 mb-1 text-secondary">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            评论了
            <a href="{{ $notification->data['link'] }}">{{ $notification->data['post_title'] }}</a>

            <span class="meta float-right" title="{{ $notification->created_at }}">
        <i class="far fa-clock"></i>
        {{ $notification->created_at->diffForHumans() }}
      </span>
        </div>
        {{-- 回复删除按钮 浮动右边,先检查是否已删除 --}}
        <div style="float: right">
        @if(\App\Models\Reply::find($notification->data['reply_id']))
            <form action="{{ route('replies.destroy', $notification->data['reply_id']) }}"
                  method="post"
                  style="display: inline-block;"
                  onsubmit="return confirm('您确定要删除吗？');">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="far fa-trash-alt"></i> 删除回复
                </button>
            </form>
        @else
            <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="far fa-trash-alt"></i> 该回复已删除
            </button>
        @endif
        </div>

        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
    </div>
</li>
