<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'supervisor',
        // 显示名
        'title'   => '政府端',
        // 描述
        'description' => '管理政府端数据',
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
            'name'  => 'supervisor',
            'title' => '政府端',
            'icon'  => 'fa fa-gavel'
        ),
        array(
            'name'  => 'supervisor-department-index',
            'title' => '部门管理',
            'url'   => 'supervisor/department/index',
            'parent' => 'supervisor',
            'permission' => 'SUPERVISOR_DEPARTMENT_MANAGE'
        ),
        array(
            'name'  => 'supervisor-spot-check-index',
            'title' => '抽检管理',
            'url'   => 'supervisor/spot-check/index',
            'parent' => 'supervisor',
            'permission' => 'SUPERVISOR_SPOT_CHECK_MANAGE'
        ),
        array(
            'name'  => 'supervisor-complaint-index',
            'title' => '投诉管理',
            'url'   => 'supervisor/complaint/index',
            'parent' => 'supervisor',
            'permission' => 'SUPERVISOR_COMPLAINT_MANAGE'
        ),
        array(
            'name'  => 'supervisor-data',
            'title' => '环境数据',
            'parent' => 'supervisor'
        ),
        array(
            'name'  => 'supervisor-data-water-index',
            'title' => '水质数据',
            'url'   => 'supervisor/water/index',
            'parent' => 'supervisor-data',
            'permission' => 'SUPERVISOR_WATER_MANAGE'
        ),
        array(
            'name'  => 'supervisor-data-species-index',
            'title' => '生物多样性数据',
            'url'   => 'supervisor/species/index',
            'parent' => 'supervisor-data',
            'permission' => 'SUPERVISOR_SPECIES_MANAGE'
        ),
        array(
            'name'  => 'supervisor-data-video-index',
            'title' => '视频数据',
            'url'   => 'supervisor/video/index',
            'parent' => 'supervisor-data',
            'permission' => 'SUPERVISOR_VIDEO_MANAGE'
        ),
        array(
            'name'  => 'supervisor-data-warning-index',
            'title' => '环境污染预警',
            'url'   => 'supervisor/warning/index',
            'parent' => 'supervisor-data',
            'permission' => 'SUPERVISOR_WARNING_MANAGE'
        ),

        array(
            'name'  => 'supervisor-statistics',
            'title' => '统计管理',
            'parent' => 'supervisor',
        ),
        array(
            'name'  => 'supervisor-annual-trend-index',
            'title' => '行业年度营收趋势',
            'url'   => 'supervisor/annual-trend/index',
            'parent' => 'supervisor-statistics',
            'permission' => 'SUPERVISOR_ANNUAL_TREND_MANAGE'
        ),
        array(
            'name'  => 'supervisor-industry-weight-index',
            'title' => '行业分布',
            'url'   => 'supervisor/industry-weight/index',
            'parent' => 'supervisor-statistics',
            'permission' => 'SUPERVISOR_INDUSTRY_WEIGHT_MANAGE'
        ),
    ),

    'permission' => [
        'SUPERVISOR_DEPARTMENT_MANAGE' => ['title' => '部门管理'],
        'SUPERVISOR_SPOT_CHECK_MANAGE' => ['title' => '抽检管理'],
        'SUPERVISOR_COMPLAINT_MANAGE' => ['title' => '投诉管理'],
        'SUPERVISOR_WATER_MANAGE' => ['title' => '水质数据'],
        'SUPERVISOR_SPECIES_MANAGE' => ['title' => '生物多样性数据'],
        'SUPERVISOR_VIDEO_MANAGE' => ['title' => '视频数据'],
        'SUPERVISOR_WARNING_MANAGE' => ['title' => '环境污染预警'],
        'SUPERVISOR_ANNUAL_TREND_MANAGE' => ['title' => '行业年度营收趋势'],
        'SUPERVISOR_INDUSTRY_WEIGHT_MANAGE' => ['title' => '行业分布'],
    ]
);
