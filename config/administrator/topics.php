<?php

use App\Models\Topic;

return [
    'title' => '话题',
    'single' => '话题',
    'model' => Topic::class,

    'columns' => [

        'id' => [
            'title' => 'ID',
        ],
        'title' => [
            'title' => '话题',
            'sortable' => false,
            'output' => function ($value, $model) {
                return '<div style="max-width:260px">' . model_link($value, $model) . '</div>';
            },
        ],
        'user' => [
            'title' => '作者',
            'sortable' => false,
            'output' => function ($value, $model) {
                return model_link($model->user->username, $model);
            },
        ],
        'problem' => [
            'title' => '问题id',
            'sortable' => false,
            'output' => function ($value, $model) {
                return model_link($model->problem->id, $model->problem);
            },
        ],
        'reply_count' => [
            'title' => '评论数',
        ],
        'updated_at' => [
            'title' => '更新时间',
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'title' => [
            'title' => '标题',
        ],
        'user' => [
            'title' => '用户',
            'type' => 'relationship',
            'name_field' => 'username',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete' => true,

            // 自动补全的搜索字段
            'search_fields' => ["CONCAT(id, ' ', username)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'problem' => [
            'title' => '问题',
            'type' => 'relationship',
            'name_field' => 'id',
            'search_fields' => ["CONCAT(id)"],
            'options_sort_field' => 'id',
        ],
        'reply_count' => [
            'title' => '评论数',
        ],
        'view_count' => [
            'title' => '查看',
        ],
    ],
    'filters' => [
        'id' => [
            'title' => '内容 ID',
        ],
        'user' => [
            'title' => '用户',
            'type' => 'relationship',
            'name_field' => 'username',
            'autocomplete' => true,
            'search_fields' => array("CONCAT(id, ' ', username)"),
            'options_sort_field' => 'id',
        ],
        'problem' => [
            'title' => '问题',
            'type' => 'relationship',
            'name_field' => 'id',
            'search_fields' => array("CONCAT(id"),
            'options_sort_field' => 'id',
        ],
    ],
    'rules' => [
        'title' => 'required',
    ],
    'messages' => [
        'title.required' => '请填写标题',
    ],
];
