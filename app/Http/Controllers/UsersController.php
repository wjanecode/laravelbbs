<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct(  ) {
        $this->middleware('auth',['except'=>'show']);//除了show方法,其他方法要先验证是否登录,就是游客只能访问show
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $user = User::find($id);
        //授权策略,第一个参数是策略类的update方法,第二个参数是要修改的用户信息
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,ImageUploadHandler $uploader, $id)
    {

        $user = User::find($id);

        //授权策略,第一个参数是策略类的update方法,第二个参数是要修改的用户信息
        $this->authorize('update',$user);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->introduce = $request->get('introduce');
        //判断有没有上传图片
        if ($request->avatar){
            $result = $uploader->upload($request->avatar,'avatar','avatar',650);//转存头像
            $user->avatar = $result['path'];
        }

        $user->save();
        session()->flash('success','个人信息修改成功');
        return redirect(route('users.show',\Auth::id()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
