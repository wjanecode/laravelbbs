<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);//权限检查,没登录不允许修改保存删除
    }

	public function index()
	{
		$replies = Reply::paginate();
		return view('replies.index', compact('replies'));
	}

    public function show(Reply $reply)
    {
        return view('replies.show', compact('reply'));
    }



	public function store(ReplyRequest $request,Reply $reply)
	{
        $reply->content = $request->get('content');
		$reply->post_id = $request->get('post_id');
		$reply->user_id = \Auth::id();

		$reply->save();
		return back()->with('success', '回复成功');
	}

	public function edit(Reply $reply)
	{
        $this->authorize('update', $reply);
		return view('replies.create_and_edit', compact('reply'));
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);//权限策略,本人可以更新本人的,其他人不允许修改
		$reply->update($request->all());

		return redirect()->route('replies.show', $reply->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return back()->with('success', '回复删除成功');
	}
}
