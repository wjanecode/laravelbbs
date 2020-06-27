<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

return [
    // 页面标题
    'title'   => '角色',

    // 模型单数，用作页面『新建 $single』
    'single'  => '角色',

    // 数据模型，用作数据的 CRUD
    'model'   => Role::class,

    // 设置当前页面的访问权限，通过返回布尔值来控制权限。
    // 返回 True 即通过权限验证，False 则无权访问并从 Menu 中隐藏
    'permission'=> function()
    {
        return Auth::user()->can('manage_contents');
    },

    // 字段负责渲染『数据表格』，由无数的『列』组成，
    'columns' => [

        // 列的标示，这是一个最小化『列』信息配置的例子，读取的是模型里对应
        // 的属性的值，如 $model->id
        'id',

        'name' => [
            // 数据表格里列的名称，默认会使用『列标识』
            'title'  => '名称',

            // 默认情况下会直接输出数据，你也可以使用 output 选项来定制输出内容

            // 是否允许排序
            'sortable' => false,
        ],

        'permissions' => [
            'title' => '权限',

            'output' => function($value,$model){
                $model->load('permissions');
                $result = [];
                foreach ($model->permissions as $permission){
                    $result[] = $permission->name;
                }

                return empty($result) ? 'N/A' : implode($result,' | ');

            }
        ],

        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    // 『模型表单』设置项
    'edit_fields' => [
        'name' => [
            'title' => '名称',
        ],


        'permissions' => [
            'title'      => '权限',

            // 指定数据的类型为关联模型
            'type'       => 'relationship',

            // 关联模型的字段，用来做关联显示
            'name_field' => 'name',
        ],
    ],

    // 『数据过滤』设置
    'filters' => [
        'id' => [

            // 过滤表单条目显示名称
            'title' => '角色 ID',
        ],
        'name' => [
            'title' => '角色名称',
        ],
        'permissions' => [
            'title' => '权限',
        ],
    ],

    // 新建和编辑时的表单验证规则
    'rules' => [
        'name' => 'required|max:15|unique:roles,name',
    ],

    // 表单验证错误时定制错误消息
    'messages' => [
        'name.required' => '标识不能为空',
        'name.unique' => '标识已存在',
    ]
];
