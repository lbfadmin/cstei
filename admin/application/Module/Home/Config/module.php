<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'home',
        // 显示名
        'title'   => '管理主页模块',
        // 描述
        'description' => '管理平台控制面板',
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
            'name'  => 'home-index',
            'title' => '控制面板',
            'url'   => 'dashboard',
            'icon'  => 'fa fa-dashboard',
            'weight' => -1000
        ),
    ),

);
