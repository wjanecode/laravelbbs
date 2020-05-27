<?php

namespace App\Http\Requests;

class PostRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    // CREATE ROLES
                    'title' => 'required|min:2',
                    'body' => 'required|min:8',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            // Validation messages
            'title.required' => '标题不能为空!',
            'title.min' => '标题不能少于两个字符!',
            'body.required' => '内容不能为空!',
            'body.min' => '内容不能少于8个字符!'
        ];
    }
}
