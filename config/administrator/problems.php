<?php

use App\Models\Problem;

return [
    'title' => '问题',
    'single' => '问题',
    'model' => Problem::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            return Auth::user()->hasRole('root');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '名称',
            'sortable' => false,
        ],
        'description' => [
            'title' => '描述',
            'sortable' => false,
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
            'type' => 'textarea',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '问题 ID',
        ],
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
        ],
    ],
    'rules' => [
        'name' => 'required|min:1|unique:categories',
    ],
    'messages' => [
        'name.unique' => '问题名在数据库里有重复，请选用其他名称。',
        'name.required' => '请确保名字至少一个字符以上',
    ],
];
