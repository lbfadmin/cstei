<?php

/**
 * Configrations.
 * 
 * @copyright xlight http://www.im87.cn
 */

return array(
    // 公共配置(必须)
    'common' => array(
        // 是否调试模式
        'debug'             => true,
        // 默认模块
        'defaultModule'     => 'Home',
        // 默认控制器
        'defaultController' => 'Main',
        // 默认操作
        'defaultAction'     => 'index',
        // 默认首页
        'frontPage'         => 'welcome',
        // 异常处理
        'errorHandler'      => array('Application\Controller\Api', 'exceptionHandler'),
        'exceptionHandler'  => array('Application\Controller\Api', 'exceptionHandler'),
        // 是否开启url重写
        'urlRewrite'        => true,
        // cookie domain
        'cookieDomain'      => '',
        // 程序加密salt
        'salt'              => '06c23537c5da50e2524d7fb8',
        // 已添加的模块
        'modules'           => array(
            'Home', 'Account', 'Common', 'Queue', 'Log',
            'Content',
            'Project',
            'Supervisor',
            'Producer',
            'Consumer',
            'Statistic'
        ),

        'miscBaseUrl'       => '',
        'fileBaseUrl'       => 'http://images.marinefish.cn/',
        'imageBaseUrl'      => 'http://images.marinefish.cn/',
        'wwwBaseUrl'        => '',
    ),

    // api设置
    'api' => array(
        'debug' => true,
        'auth' => array(
            'www' => 'BBz2EgfZ5B2GE6dhwwGzXhnarC1ZK6dm',
            'admin'  => 'BBz2EgfZ5B2GE6dhwwGzXhnarC1ZK6dm',
        )
    ),

    // 日志设置
    'log' => array(
        // 记录api请求
        'api' => true
    ),
    
    // System\Component\Http
    'Http' => array(
        'baseUrl'      => '',
        // Set this if the site is using a sub-domain as main domain.
        //'baseDomain' => 'sub.example.com'
    ),
    
    // mysql
    'Mysql' => array(
        'main' => array(
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '123456',
            'database' => 'cstei_main',
            'hostport' => '3306',
            'prefix'   => '',
            'pconnect' => true,
            'filterFields' => false
        ),
    ),

    // mongodb
    'Mongodb' => array(
        'log' => array(
            'host' => '',
            'port' => '27017',
            'database' => '',
            'username' => '',
            'password' => ''
        )
    ),

    'Oss' => [
        'main' => [
            'accessKeyId' => 'LTAIKyFTpu8SnaA8',
            'accessKeySecret' => 'psyYjAXKgjFvLG3K0TAwxn8NTf5xnU',
            'endpoint' => 'oss-cn-qingdao.aliyuncs.com',
            'bucket' => 'robotfish-dev',
            'salt' => '@~robotfish-dev~#'
        ]
    ],

    // elasticsearch
    'Elasticsearch' => array(
        'main' => array(
            'hosts' => ['elasticsearch']
        ),
    ),

    // redis
    'Redis' => array(
        'queue' => array(
            'host'     => '',
            'port'     => 6379,
            'database' => 0
        )
    ),
    
    // System\Component\View
    'View' => array(
        'extension'    => '.tpl.php',
        'debug'        => false
    ),
    
    // System\Component\Cache
    'Cache' => array(
        'Db' => array(
            'params' => array(
                'table' => 'cache'
            )
        )
    ),

    'Mail' => array(
        'notifier' => array(
            'key'    => 'key-6849daa201fc1e74db2ee9e37fb2f3ff',
            'domain' => 'mail.dianhou.com',
            'from'   => '电猴网<notice@dianhouwang.com>'
        ),
    ),
    
    // System\Component\Filter
    'Filter' => array(
        'allowedProtocols' => array(
            'ftp', 'http', 'https', 'irc', 'mailto', 'news', 
            'nntp', 'rtsp', 'sftp', 'ssh', 'tel', 'telnet', 'webcal'
        )
    ),

);
