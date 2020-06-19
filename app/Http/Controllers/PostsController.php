<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Auth;

class PostsController extends Controller
{
    /**
     * 构造器,权限认证,除了列表index show 别的方法都需要验证,except黑名单制
     * PostsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
	{
		$posts = Post::withOrder(\request('order'))->with('user','category')->paginate();
		return view('posts.index', compact('posts'));
	}

    /**
     * 详情页
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        //意此处使用 Laravel 的 『隐性路由模型绑定』 功能，
        //当请求 larabbs.test/topics/1 时，$topic 变量会自动解析为 ID 为 1 的帖子对象。

        return view('posts.show', compact('post'));
    }

    /**
     * 返回创建页面
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function create(Post $post)
	{
	    $categories = Category::all();

		return view('posts.create_and_edit', compact('post','categories'));
	}

    /**
     * 保存新帖子
     * @param PostRequest $request
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(PostRequest $request,Post $post)
	{
        $request->body = clean($request->body, 'default');//对HTML内容进行过滤,purifier 防止注入攻击
		$post->fill($request->all());
		$post->user_id = Auth::id();
		$post->save();
		return redirect()->route('posts.show', $post->id)->with('message', '帖子创建成功');
	}

    /**
     * 返回编辑页
     * @param Post $post
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function edit(Post $post)
	{
        $this->authorize('update', $post);
		return view('posts.create_and_edit', compact('post'));
	}

    /**
     * 保存更新数据
     * @param PostRequest $request
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function update(PostRequest $request, Post $post)
	{
		$this->authorize('update', $post);

        $request->body = clean($request->body, 'default');//对HTML内容进行过滤,purifier 防止注入攻击
		$post->update($request->all());

		return redirect()->route('posts.show', $post->id)->with('message', 'Updated successfully.');
	}

    /**
     * 删除
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function destroy(Post $post)
	{
		$this->authorize('destroy', $post);
		$post->delete();

		return redirect()->route('posts.index')->with('message', 'Deleted successfully.');
	}

    /**
     * 帖子图片上传
     * @param Request $request
     * @param ImageUploadHandler $uploader
     *
     * @return array
     */
    public function uploadImage(Request $request,ImageUploadHandler $uploader) {

	    //初始化默认返回数据,默认返回失败
        //编辑器上传返回的数据要求可以看文档
        //https://simditor.tower.im/docs/doc-config.html#anchor-upload
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        //判断是否有上传文件
        if($file = $request->upload_file){
            //保存文件到本地
            $result = $uploader->upload($file,'post','post_img');
            //如果保存成功,修改返回数据
            if ($result) {
                $data['file_path'] =asset($result['path']);//直接返回完整路径,不然会显示错误
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        //返回结果,编辑器要求的是json格式,laravel会自动把返回的数组转json
        return $data;
	}
}
