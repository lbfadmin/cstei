<?php

return array(
    '' => 'home/index',
    // 首页
    'hunter/dashboard' => 'hunter/home/dashboard',
    'hr/dashboard'     => 'hr/home/dashboard',
    // 注册
    'account/register' => '@Account:Account:register',
    // 登录
    'account/login'    => '@Account:Account:login',
    // 注销
    'account/logout'   => '@Account:Account:logout',
    // 关于
    'about/(.*)'       => 'content/about/$1',
);
