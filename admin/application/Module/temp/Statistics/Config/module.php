<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'producer',
        // 显示名
        'title'   => '企业端',
        // 描述
        'description' => '管理企业端数据',
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
            'name'  => 'producer',
            'title' => '企业端',
            'icon'  => 'fa fa-industry'
        ),
        array(
            'name'  => 'producer-company',
            'title' => '企业管理',
            'parent' => 'producer',
            'weight' => '-1'
        ),
        array(
            'name'  => 'producer-company-company-index',
            'title' => '企业信息',
            'url'   => 'producer/company/company/index',
            'parent' => 'producer-company',
            'permission' => 'PRODUCER_COMPANY_MANAGE'
        ),
        array(
            'name'  => 'producer-company-qualification-index',
            'title' => '企业资质',
            'url'   => 'producer/company/qualification/index',
            'parent' => 'producer-company',
            'permission' => 'PRODUCER_COMPANY_QUALIFICATION_MANAGE'
        ),
        array(
            'name'  => 'producer-company-credit-index',
            'title' => '企业诚信',
            'url'   => 'producer/company/credit/index',
            'parent' => 'producer-company',
            'permission' => 'PRODUCER_CREDIT_MANAGE'
        ),
        array(
            'name'  => 'producer-statistics',
            'title' => '统计管理',
            'parent' => 'producer',
            'weight' => '-1'
        ),
        array(
            'name'  => 'producer-statistics-annual-trend-index',
            'title' => '企业年度营收趋势',
            'url'   => 'producer/statistics/annual-trend/index',
            'parent' => 'producer-statistics',
            'permission' => 'PRODUCER_STATISTICS_ANNUAL_TREND'
        ),
        array(
            'name'  => 'producer-statistics-channel-weight-index',
            'title' => '企业渠道比重',
            'url'   => 'producer/statistics/channel-weight/index',
            'parent' => 'producer-statistics',
            'permission' => 'PRODUCER_STATISTICS_CHANNEL_WEIGHT'
        ),
        array(
            'name'  => 'producer-statistics-industry-weight-index',
            'title' => '企业产业比重',
            'url'   => 'producer/statistics/industry-weight/index',
            'parent' => 'producer-statistics',
            'permission' => 'PRODUCER_STATISTICS_INDUSTRY_WEIGHT'
        ),
//        array(
//            'name'  => 'producer-statistics-market-index',
//            'title' => '企业行情预估',
//            'url'   => 'producer/statistics/market/index',
//            'parent' => 'producer-statistics'
//        ),
        array(
            'name'  => 'producer-device',
            'title' => '设备管理',
            'parent' => 'producer',
        ),
        array(
            'name'  => 'producer-device-maintenance-index',
            'title' => '设备维护记录',
            'url'   => 'producer/device/maintenance/index',
            'parent' => 'producer-device',
            'permission' => 'PRODUCER_DEVICE_MAINTENANCE_MANAGE'
        ),
        array(
            'name'  => 'producer-device-power-index',
            'title' => '设备开关机记录',
            'url'   => 'producer/device/power/index',
            'parent' => 'producer-device',
            'permission' => 'PRODUCER_DEVICE_POWER_MANAGE'
        ),
        array(
            'name'  => 'producer-farming',
            'title' => '养殖管理',
            'parent' => 'producer',
        ),
        array(
            'name'  => 'producer-farming-env',
            'title' => '养殖环境管理',
            'parent' => 'producer-farming',
            'url' => 'producer/farming/env/index',
            'permission' => 'PRODUCER_FARMING_ENV_MANAGE'
        ),
        array(
            'name'  => 'producer-farming-video',
            'title' => '视频管理',
            'parent' => 'producer-farming',
            'url' => 'producer/farming/video/index',
            'permission' => 'PRODUCER_FARMING_VIDEO_MANAGE'
        ),
        array(
            'name'  => 'producer-storage',
            'title' => '仓储管理',
            'parent' => 'producer',
        ),
        array(
            'name'  => 'producer-storage-warehouse-env',
            'title' => '仓储环境',
            'parent' => 'producer-storage',
            'url' => 'producer/storage/warehouse-env/index',
            'permission' => 'PRODUCER_STORAGE_WAREHOUSE_ENV_MANAGE'
        ),
    ),

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
