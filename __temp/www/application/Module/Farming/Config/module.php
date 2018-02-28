<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'farming',
        // 显示名
        'title'   => '养殖模块',
        // 描述
        'description' => '养殖管理',
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
        [
            'name'  => 'farming',
            'title' => '养殖管理',
            'icon' => 'fa fa-leaf',
            'weight' => 20
        ],
        [
            'name'  => 'farming-pool',
            'title' => '养殖池管理',
            'icon' => 'fa fa-cubes',
            'parent' => 'farming',
            'weight' => 1
        ],
        [
            'name'  => 'farming-pool-index',
            'title' => '养殖池管理',
            'parent' => 'farming-pool',
            'url' => 'farming/pool/index',
            'permission' => 'FARMING_POOL_MANAGE'
        ],
        [
            'name'  => 'farming-pool-category-index',
            'title' => '分组管理',
            'parent' => 'farming-pool',
            'url' => 'farming/pool-category/index',
            'permission' => 'FARMING_POOL_CATEGORY_MANAGE'
        ],
        [
            'name'  => 'farming-pool-group-index',
            'title' => '循环水养殖池组',
            'parent' => 'farming-pool',
            'url' => 'farming/pool-group/index',
            'permission' => 'FARMING_POOL_GROUP_MANAGE'
        ],
        [
            'name'  => 'farming-device-index',
            'title' => '设备管理',
            'parent' => 'farming',
            'icon' => 'fa fa-cogs',
            'weight' => 2
        ],
        [
            'name'  => 'farming-device',
            'title' => '设备管理',
            'icon' => 'fa fa-list',
            'parent' => 'farming-device-index',
            'url' => 'farming/device/index',
            'permission' => 'FARMING_DEVICE_MANAGE'
        ],
        [
            'name'  => 'farming-device-category',
            'title' => '类型分类',
            'icon' => 'fa fa-list',
            'parent' => 'farming-device-index',
            'url' => 'farming/device-type-category/index',
            'permission' => 'FARMING_DEVICE_CATEGORY_MANAGE'
        ],
        [
            'name'  => 'farming-device-type',
            'title' => '类型管理',
            'icon' => 'fa fa-list',
            'parent' => 'farming-device-index',
            'url' => 'farming/device-type/index',
            'permission' => 'FARMING_DEVICE_TYPE_MANAGE'
        ],
        [
            'name'  => 'farming-batch-index',
            'title' => '批次管理',
            'icon' => 'fa fa-list',
            'parent' => 'farming',
            'url' => 'farming/batch/index',
            'weight' => 3,
            'permission' => 'FARMING_BATCH_MANAGE'
        ],
        [
            'name'  => 'farming-env',
            'title' => '养殖环境',
            'icon' => 'fa fa-list',
            'parent' => 'farming',
            'weight' => 4
        ],
        [
            'name'  => 'farming-env-index',
            'title' => '养殖环境',
            'icon' => 'fa fa-list',
            'parent' => 'farming-env',
            'url' => 'farming/production-env/index',
            'permission' => 'FARMING_ENV_MANAGE'
        ],
        [
            'name'  => 'farming-disease-index',
            'title' => '病害记录',
            'icon' => 'fa fa-list',
            'parent' => 'farming-env',
            'url' => 'farming/disease/index',
            'permission' => 'FARMING_DISEASE_MANAGE'
        ],
        [
            'name'  => 'farming-feed',
            'title' => '投放记录',
            'icon' => 'fa fa-clock-o',
            'parent' => 'farming',
            'weight' => 5
        ],
        [
            'name'  => 'farming-feed-index',
            'title' => '饲料信息',
            'parent' => 'farming-feed',
            'url'    => 'farming/feed/index',
            'permission' => 'FARMING_FEED_MANAGE'
        ],
        [
            'name'  => 'farming-feed_use-index',
            'title' => '饲料投放记录',
            'parent' => 'farming-feed',
            'url'    => 'farming/feed-use/index',
            'permission' => 'FARMING_FEED_USE_MANAGE'
        ],
        [
            'name'  => 'farming-medicine-index',
            'title' => '渔药信息',
            'parent' => 'farming-feed',
            'url'    => 'farming/medicine/index',
            'permission' => 'FARMING_MEDICINE_MANAGE'
        ],
        [
            'name'  => 'farming-medicine_use-index',
            'title' => '渔药投放记录',
            'parent' => 'farming-feed',
            'url'    => 'farming/medicine-use/index',
            'permission' => 'FARMING_MEDICINE_USE_MANAGE'
        ],
        [
            'name'  => 'farming-check-index',
            'title' => '抽检记录',
            'parent' => 'farming',
            'icon' => 'fa fa-flask',
            'url' => 'farming/check/index',
            'weight' => 6,
            'permission' => 'FARMING_CHECK_MANAGE'
        ],

        [
            'name'  => 'processing',
            'title' => '加工管理',
            'icon' => 'fa fa-wrench',
            'weight' => 30
        ],
        [
            'name'  => 'temp-pool-index',
            'title' => '暂养池',
            'parent' => 'processing',
            'icon' => 'fa fa-wrench',
            'url' => 'farming/temp-pool/index',
            'weight' => 1,
            'permission' => 'FARMING_TEMP_POOL_MANAGE'
        ],
        [
            'name'  => 'processing-processing-index',
            'title' => '加工记录',
            'parent' => 'processing',
            'icon' => 'fa fa-clock-o',
            'url' => 'farming/processing/index',
            'weight' => 2,
            'permission' => 'FARMING_PROCESSING_MANAGE'
        ],
    ),

    // 权限
    'permission' => [
        'FARMING_POOL_MANAGE' => [
            'title' => '养殖池管理'
        ],
        'FARMING_POOL_CATEGORY_MANAGE' => [
            'title' => '养殖池分组管理'
        ],
        'FARMING_POOL_GROUP_MANAGE' => [
            'title' => '循环水养殖池管理'
        ],
        'FARMING_DEVICE_GROUP_MANAGE' => [
            'title' => '循环水养殖池设备组管理'
        ],
        'FARMING_DEVICE_MANAGE' => [
            'title' => '设备管理'
        ],
        'FARMING_DEVICE_MAINTENANCE_MANAGE' => [
            'title' => '设备维护记录管理'
        ],
        'FARMING_DEVICE_POWER_MANAGE' => [
            'title' => '设备开关机记录管理'
        ],
        'FARMING_DEVICE_CATEGORY_MANAGE' => [
            'title' => '设备类型分类管理'
        ],
        'FARMING_DEVICE_TYPE_MANAGE' => [
            'title' => '设备类型管理'
        ],
        'FARMING_BATCH_MANAGE' => [
            'title' => '批次管理'
        ],
        'FARMING_ENV_MANAGE' => [
            'title' => '养殖环境管理'
        ],
        'FARMING_VIDEO_MANAGE' => [
            'title' => '养殖视频管理'
        ],
        'FARMING_DISEASE_MANAGE' => [
            'title' => '病害记录管理'
        ],
        'FARMING_FEED_MANAGE' => [
            'title' => '饲料信息管理'
        ],
        'FARMING_FEED_USE_MANAGE' => [
            'title' => '饲料投放记录管理'
        ],
        'FARMING_MEDICINE_MANAGE' => [
            'title' => '渔药信息管理'
        ],
        'FARMING_MEDICINE_USE_MANAGE' => [
            'title' => '渔药投放记录管理'
        ],
        'FARMING_CHECK_MANAGE' => [
            'title' => '抽检记录管理'
        ],
        'FARMING_TEMP_POOL_MANAGE' => [
            'title' => '暂养池管理'
        ],
        'FARMING_TEMP_POOL_ENV_MANAGE' => [
            'title' => '暂养池环境记录管理'
        ],
        'FARMING_PROCESSING_MANAGE' => [
            'title' => '加工记录管理'
        ],
    ]
);
