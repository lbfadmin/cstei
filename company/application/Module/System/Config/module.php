<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'system',
        // 显示名
        'title'   => '系统模块',
        // 描述
        'description' => '系统管理',
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
            'name'  => 'system',
            'title' => '系统设置',
            'icon'  => 'fa fa-cog',
            'weight' => -100,
        ),
        array(
            'name'  => 'system-admin',
            'title' => '管理员管理',
            'url'   => 'system/admin/index',
            'permission' => 'SYSTEM_ADMIN_MANAGE',
            'parent' => 'system',
            'icon'  => 'fa fa-users',
            'weight' => 0
        ),
        array(
            'name'  => 'system-role',
            'title' => '角色管理',
            'url'   => 'system/role/index',
            'permission' => 'SYSTEM_ROLE_MANAGE',
            'parent' => 'system',
            'icon'  => 'fa fa-user',
            'weight' => 1
        ),
        array(
            'name'  => 'system-module',
            'title'  => '模块管理',
            'url'   => 'system/module/index',
            'permission' => 'SYSTEM_MODULE_MANAGE',
            'parent' => 'system',
            'icon'  => 'fa fa-cubes',
            'weight' => 2
        ),
        array(
            'name'  => 'system-menu',
            'title'  => '菜单管理',
            'url'   => 'system/menu/index',
            'permission' => 'SYSTEM_MENU_MANAGE',
            'parent' => 'system',
            'icon'  => 'fa fa-list',
            'weight' => 3
        ),
    ),

    // 权限
    'permission' => array(
        'SYSTEM_ADMIN_MANAGE' => array(
            'title' => '管理管理员'
        ),
        'SYSTEM_ROLE_MANAGE' => array(
            'title' => '管理角色'
        ),
        'SYSTEM_MODULE_MANAGE' => array(
            'title' => '管理模块'
        ),
        'SYSTEM_MENU_MANAGE' => array(
            'title' => '管理菜单'
        ),
    )
);
