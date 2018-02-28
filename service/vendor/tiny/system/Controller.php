<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System;

use System\Component\Http\Request;

/**
 * 控制器（Controller）基类
 * 
 * 所有控制器（Controller）必须扩展此基类才能正常使用
 * 
 * @author xlight <i@im87.cn>
 */
class Controller {
    
    /**
     * 活动线程
     * @var Thread
     */
    public $thread = null;

    /**
     * @var Request
     */
    public $request = null;

    /**
     * @var Component\Http\Response
     */
    public $response = null;
    
    /**
     * __construct()
     */
    public function __construct() {
        $this->thread = Bootstrap::getActiveThread();
        $this->config = Bootstrap::getConfig();
        $this->request = $this->thread->request;
        $this->response = $this->thread->response;
        // 全局变量
        foreach (Bootstrap::getGlobal() as $key => $value) {
            $this->{$key} = $value;
        }
        
        // 调用钩子: onControllerInit()
        Bootstrap::invokeHook('onControllerInit', $this);
    }
    
    /**
     * 快捷调用路径
     * 
     * @param string $path 要调用的路径
     * @param array $args 参数
     * @return mixed
     */
    public function call($path, $args = array()) {
        return Bootstrap::call($path, $args);
    }
    
    /**
     * 内部跳转
     * 
     * @param string $path 要调用的路径
     * @param array $args 参数
     * @return mixed
     */
    public function forward($path, $args = array()) {
        Bootstrap::forward($path, $args);
    }

    /**
     * __destruct()
     */
    public function __destruct() {
        // Invoke hook: onControllerDestruct()
        Bootstrap::invokeHook('onControllerDestruct', $this);
    }
}