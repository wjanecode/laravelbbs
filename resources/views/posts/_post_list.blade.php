{{--帖子列表--}}
@if($posts->count())
    @foreach($posts as $post)

        <li class="media">
            <div class="media-left">
                <a href="{{ route('users.show', [$post->user_id]) }}">
                    <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $post->user->avatar }}" title="{{ $post->user->name }}">
                </a>
            </div>
            <div class="media-body">
                <a  class="float-right" href="{{ route('posts.show',$post->id) }}"> <span class="badge badge-secondary badge-pill"> {{ $post->reply_count }} </span></a>

                <a href="{{ route('posts.show',$post->id) }}"><h4 class="media-heading">{{ $post->title}}</h4></a>
                <small class="media-body meta text-secondary">

                    <a class="text-secondary" href="#" title="{{ $post->category->name }}">
                        <i class="far fa-folder"></i>
                        {{ $post->category->name }}
                    </a>

                    <span> • </span>
                    <a class="text-secondary" href="{{ route('users.show', [$post->user_id]) }}" title="{{ $post->user->name }}">
                        <i class="far fa-user"></i>
                        {{ $post->user->name }}
                    </a>
                    <span> • </span>
                    <i class="far fa-clock"></i>
                    <span class="timeago" title="最后活跃于：{{ $post->updated_at }}">{{ $post->updated_at->diffForHumans() }}</span>
                </small>
            </div>
        </li>
        <hr>
    @endforeach
@endif
