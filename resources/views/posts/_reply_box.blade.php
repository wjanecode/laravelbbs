@include('share.error')

<div>
    <form action="{{route('replies.store')}}" method="post">
        <div class="form-group">
            <textarea name="content" id="editor" class="form-control">{{ old('content') }}</textarea>
        </div>
        {{ csrf_field() }}
        <input type="text" hidden name="post_id" value="{{$post->id}}">
        <div class="form-group" style="text-align: right">
            <button type="submit"  class="btn btn-primary">发表回复</button>
        </div>

    </form>
</div>


