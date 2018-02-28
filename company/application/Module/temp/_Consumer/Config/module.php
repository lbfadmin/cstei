<?php

return array(
    // 信息
    'info' => array(
        // 模块名
        'name'    => 'consumer',
        // 显示名
        'title'   => '消费者端',
        // 描述
        'description' => '管理消费者端数据',
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
            'name'  => 'consumer',
            'title' => '消费者端',
            'icon'  => 'fa fa-shopping-cart'
        ),
        array(
            'name'  => 'consumer-goods',
            'title' => '商品',
            'parent' => 'consumer'
        ),
        array(
            'name'  => 'consumer-goods-goods-index',
            'title' => '商品',
            'url'   => 'consumer/goods/goods/index',
            'parent' => 'consumer-goods',
            'permission' => 'CONSUMER_GOODS_MANAGE'
        ),
        array(
            'name'  => 'consumer-goods-category-index',
            'title' => '类目',
            'url'   => 'consumer/goods/category/index',
            'parent' => 'consumer-goods',
            'permission' => 'CONSUMER_GOODS_CATEGORY_MANAGE'
        ),
        array(
            'name'  => 'consumer-shopping-platform-index',
            'title' => '电商平台',
            'url'   => 'consumer/shopping-platform/index',
            'parent' => 'consumer',
            'permission' => 'CONSUMER_SHOPPING_PLATFORM_MANAGE'
        ),
        array(
            'name'  => 'consumer-purchase-index',
            'title' => '购买/评价',
            'url'   => 'consumer/purchase/index',
            'parent' => 'consumer',
            'permission' => 'CONSUMER_PURCHASE_MANAGE'
        ),
    ),

    'permission' => [
        'CONSUMER_GOODS_MANAGE' => [
            'title' => '管理商品'
        ],
        'CONSUMER_GOODS_CATEGORY_MANAGE' => [
            'title' => '管理商品类目'
        ],
        'CONSUMER_SHOPPING_PLATFORM_MANAGE' => [
            'title' => '管理电商平台'
        ],
        'CONSUMER_PURCHASE_MANAGE' => [
            'title' => '管理购买/评价'
        ],
    ]
);
