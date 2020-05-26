<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|between:3,25|unique:users,name,'.\Auth::id(),//数据表中唯一,当前id除外,后面有个逗号
            'email' => 'required|email|unique:users,email,'.\Auth::id(),
            'introduce' => 'max:1000',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=108,min_height=108',
        ];
    }
    public function messages() {
        return [
            'name.required' => '用户名不能为空',
            'name.unique' => '用户名已存在',
            'name.between' => '用户名必须3到25个字符',
            'email.required' => '邮箱不能为空',
            'email.email'   => '邮箱格式不正确',
            'email.unique' => '该邮箱已被注册',
            'introduce.max' => '个人简介不能超1000',
            'avatar.mimes' =>'头像必须是 jpeg, bmp, png, gif 格式的图片',
            'avatar.dimensions' => '图片的清晰度不够，宽和高需要 108px 以上',
        ];
    }
}
