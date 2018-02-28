<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'project',
        // 显示名
        'title'   => '项目管理模块',
        // 描述
        'description' => '管理项目',
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
            'title' => '项目管理',
            'url'   => 'project/project/index',
            'parent' => 'project',
            'permission' => 'PROJECT_PROJECT_MANAGE'
        ),
        array(
            'name'  => 'project-product-type-index',
            'title' => '产品类型管理',
            'url'   => 'project/product-type/index',
            'parent' => 'project',
            'permission' => 'PROJECT_PRODUCT_TYPE_MANAGE'
        ),
        array(
            'name'  => 'project-product-type-category-index',
            'title' => '产品分类',
            'url'   => 'project/product-type-category/index',
            'parent' => 'project',
            'permission' => 'PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE'
        ),
    ),

    'permission' => [
        'PROJECT_PROJECT_MANAGE' => [
            'title' => '管理项目'
        ],
        'PROJECT_PRODUCT_TYPE_MANAGE' => [
            'title' => '管理产品类型'
        ],
        'PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE' => [
            'title' => '管理产品类型分类'
        ],
    ]
);
