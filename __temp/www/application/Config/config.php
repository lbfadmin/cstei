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
        // 系统模板
        'tpl' => array(
            // 常规模式
            'default' => array(
                'error' => 'Application\Resource\views\default\error',
                'exception' => 'Application\Resource\views\default\error',
                '404' => 'Application\Resource\views\default\404'
            ),
            // 调试模式
            'debug' => array(
                'error' => '',
                'exception' => '',
            )
        ),
        // 是否开启url重写
        'urlRewrite'        => true,
        // cookie domain
        'cookieDomain'      => '',
        // 程序加密salt
        'salt'              => '',
        // 已添加的模块
        'modules'           => array(
            'Account', 'System', 'Common', 'Home', 'Content', 'Trace'
        ),

        'miscBaseUrl'       => '',
        'imageBaseUrl'      => '',
        'wwwBaseUrl'        => '',
        'supervisorBaseUrl' => 'http://ocean-gov.luobofei.com.cn:8800/',
        'producerBaseUrl'   => 'http://ocean-co.luobofei.com.cn:8800/',
        'baseDomain'        => ''
    ),

    // 服务
    'service' => array(
        'apiKey'    => 'www',
        'apiSecret' => 'OYK1duMTVjHgXCFvkuTijEwdPJcEzCwx',
        'baseUrl'   => 'http://127.0.0.1:11034/',
        'debug'     => true
    ),
    
    // System\Component\View
    'View' => array(
        'extension'    => '.tpl.php',
        'debug'        => false
    ),
    
    // System\Component\Filter
    'Filter' => array(
        'allowedProtocols' => array(
            'ftp', 'http', 'https', 'irc', 'mailto', 'news', 
            'nntp', 'rtsp', 'sftp', 'ssh', 'tel', 'telnet', 'webcal'
        )
    ),

);
