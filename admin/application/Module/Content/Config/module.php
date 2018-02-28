<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'content',
        // 显示名
        'title'   => '内容模块',
        // 描述
        'description' => '内容管理',
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
            'name'  => 'content',
            'title' => '内容管理',
            'icon'  => 'fa fa-pencil-square-o',
            'weight' => -100,
        ),
        array(
            'name'  => 'content-page',
            'title' => '页面',
            'icon'  => 'fa fa-book',
            'parent' => 'content',
            'url'   => 'content/page/index',
            'permission' => 'CONTENT_PAGE_MANAGE',
        ),
        array(
            'name'  => 'content-info',
            'title' => '资讯',
            'icon'  => 'fa fa-book',
            'parent' => 'content',
        ),
        array(
            'name'  => 'content-info-index',
            'title' => '资讯',
            'icon'  => 'fa fa-book',
            'parent' => 'content-info',
            'url'   => 'content/info/info/index',
            'permission' => 'CONTENT_INFO_MANAGE',
        ),
        array(
            'name'  => 'content-info-category-index',
            'title' => '分类',
            'icon'  => 'fa fa-list',
            'parent' => 'content-info',
            'url'   => 'content/info/category/index',
            'permission' => 'CONTENT_INFO_CATEGORY_MANAGE',
        ),
    ),

    // 权限
    'permission' => array(
        'CONTENT_PAGE_MANAGE' => array(
            'title' => '管理页面'
        ),
        'CONTENT_INFO_MANAGE' => array(
            'title' => '管理资讯'
        ),
        'CONTENT_INFO_CATEGORY_MANAGE' => array(
            'title' => '管理资讯分类'
        ),
    )
);
