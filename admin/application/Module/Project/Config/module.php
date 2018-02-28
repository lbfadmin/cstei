<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'project',
        // 显示名
        'title'   => '园区工程管理',
        // 描述
        'description' => '工程维修',
        // 版本
        'version' => '',
        // 作者
        'author'  => array(
            'name' => 'xlight',
            'email' => 'i@im87.cn',
            'homepage' => 'http://www.im87.cn'
        ),
    ),

    // 菜单
    'menu' => array(
        array(
            'name'  => 'project',
            'title' => '项目管理',
            'icon'  => 'fa fa-cubes'
        ),
        array(
            'name'  => 'project-index',
            'title' => '维修列表',
            'url'   => 'project/project/index',
            'parent' => 'project',
            'permission' => 'PROJECT_PROJECT_MANAGE'
        ),

    ),

    'permission' => [
        'PROJECT_PROJECT_MANAGE' => [
            'title' => '园区工程管理'
        ],

    ]
);
