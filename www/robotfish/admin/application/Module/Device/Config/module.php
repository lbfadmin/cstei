<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'device',
        // 显示名
        'title'   => '园区设备',
        // 描述
        'description' => '孵化器企业设备管理',
        // 版本
        'version' => '1.0',
        // 作者
        'author'  => array(
            'name' => 'yueliang',
            'email' => 'i@im87.cn',
            'homepage' => 'http://www.im87.cn'
        ),
    ),

    // 菜单
    'menu' => array(
        array(
            'name'  => 'device',
            'title' => '园区设备',
            'icon'  => 'fa fa-industry'
        ),

        array(
            'name'  => 'device-device-index',
            'title' => '设备管理',
            'url'   => 'device/device/index',
            'parent' => 'device',
            'permission' => ''
        ),
        array(
            'name'  => 'couveuse-device-type-index',
            'title' => ' 设备类型管理',
            'url'   => 'couveuse/device/type/index',
            'parent' => 'couveuse',
            'permission' => ''
        ),
        array(
            'name'  => 'device-device-type-index',
            'title' => ' 设备申请管理',
            'url'   => 'device/device/use/index',
            'parent' => 'couveuse',
            'permission' => ''
        ),    ),

    'permission' => [
        'PRODUCER_COMPANY_MANAGE' => [
            'title' => '管理企业信息'
        ],
        'PRODUCER_COMPANY_QUALIFICATION_MANAGE' => [
            'title' => '管理企业资质'
        ],
        'PRODUCER_CREDIT_MANAGE' => [
            'title' => '管理企业诚信'
        ],
        'PRODUCER_STATISTICS_ANNUAL_TREND' => [
            'title' => '管理企业年度营收趋势'
        ],
        'PRODUCER_STATISTICS_CHANNEL_WEIGHT' => [
            'title' => '管理企业渠道比重'
        ],
        'PRODUCER_STATISTICS_INDUSTRY_WEIGHT' => [
            'title' => '管理企业产业比重'
        ],
        'PRODUCER_DEVICE_MAINTENANCE_MANAGE' => [
            'title' => '管理设备维护记录'
        ],
        'PRODUCER_DEVICE_POWER_MANAGE' => [
            'title' => '管理设备开关机记录'
        ],
        'PRODUCER_FARMING_ENV_MANAGE' => [
            'title' => '养殖环境管理'
        ],
        'PRODUCER_FARMING_VIDEO_MANAGE' => [
            'title' => '养殖视频管理'
        ],
        'PRODUCER_STORAGE_WAREHOUSE_ENV_MANAGE' => [
            'title' => '仓储环境管理'
        ],
    ]
);
