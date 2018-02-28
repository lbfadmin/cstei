<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System;

use System\Loader;
use System\Component\Http;

/**
 * 线程（Thread）
 * 
 * 实现程序的单实例“多开”
 * 
 * @author xlight <i@im87.cn>
 */
class Thread {
    
    /**
     * 线程路径
     * @var string
     */
    private $path = '';
    
    /**
     * 参数
     * @var array
     */
    private $args = array();
    
    /**
     * 配置
     * @var array
     */
    private $config = array();
    
    /**
     * 模块列表
     * @var array
     */
    private $modules = array();
    
    /**
     * 当前模块
     * @var string
     */
    private $module = '';
    
    /**
     * 当前控制器名称
     * @var string
     */
    private $controllerName = '';

    /**
     * 控制器完整名称
     * @var string
     */
    private $controllerNS = '';

    /**
     * 控制器片段
     * @var string
     */
    private $controllerSegments = '';

    /**
     * 解析后的路径
     * @var string
     */
    private $parsedPath = '';

    /**
     * 手动路由规则
     * @var array
     */
    private $routingRule = array();

    /**
     * @var Http\Request
     */
    public $request = null;

    /**
     * @var Http\Response
     */
    public $response = null;

    /**
     * 当前操作
     * @var string
     */
    private $action = '';
    
    /**
     * __construct()
     */
    public function __construct($path = '', $args = array()) {
        $path && $this->setPath($path);
        $args && $this->args = $args;
        $this->config = Bootstrap::getConfig();
        $this->modules = Bootstrap::getModules();
        $this->routing();
        $this->initModule();
        $this->request = new Http\Request($path);
        $this->response = new Http\Response;

        Bootstrap::invokeHook('onThreadInit', $this);
    }
    
    /**
     * 设置请求路径
     * 
     * @param string $path 内部路径
     */
    public function setPath($path) {
        $this->path = $path;
        $this->parsedPath = preg_replace_callback('#[-_](\S)#i', function($m) {
            return strtoupper($m[1]);
        }, $this->path);
    }
    
    /**
     * 获取请求路径
     * 
     * @return string 内部路径
     */
    public function getPath() {
        return $this->path;
    }
    
    /**
     * 为当前路径做路由处理
     * 
     * 解析当前url，并查找是否存在定义的url别名
     */
    public function routing() {
        $path = $this->getPath();
        $rules = Bootstrap::getRoutingRules();
        if ($rules !== false && is_array($rules)) {
            // 查找路由规则
            foreach ($rules as $alias => $target) {
                // 路由规则存在
                if (preg_match('#^' . $alias . '$#i', $path)) {
                    // 路由回调
                    if (is_callable($target)) {
                        $path = call_user_func_array($target, [$path, $alias]);
                    }
                    // 向后引用
                    elseif (strstr($target, '$') && strstr($alias, '(')) {
                        $path = preg_replace('#^' . $alias . '$#i', $target, $path);
                    } else {
                        $path = $target;
                    }
                    // 直接路由
                    if (strpos($path, '@') === 0) {
                        $this->routingRule = explode(':', substr($path, 1));
                    }
                    // 路由别名
                    else {
                        $this->setPath($path);
                    }
                    break;
                } 
            }
        }
    }
    
    /**
     * 初始化模块
     */
    public function initModule() {
        $module = $this->getModule();
        if ($module !== '') {
            $config = Loader::load("Module\\{$module}\\Config\\config");
            if ($config) {
                $this->config = merge_options($this->config, $config);
            }
            // 调用钩子: onModuleInit().
            Bootstrap::invokeHook('onModuleInit');
        }
        return $this;
    }
    
    /**
     * 获取当前模块
     * 
     * @return string 当前模块名
     */
    public function getModule() {
        if ($this->module === '') {
            if (empty($this->modules)) {
                return '';
            }
            $module = '';
            // 手动路由
            if (! empty($this->routingRule)) {
                $module = $this->routingRule[0];

            }
            // 自动路由
            else {
               // print_r($this->modules);
                foreach ($this->modules as $v) {
                    $tmp = str_replace('\\', '/', $v);
                    $m = preg_match('#^' . $tmp . '/?#i', $this->parsedPath);
                    if ($m === 1) {
                        $module = $v;
                        break;
                    }
                }
               // print_r($module);
                if (! $module && $this->config['common']['defaultModule']) {
                    $module = $this->config['common']['defaultModule'];
                    $this->setPath($module . '/' . $this->getPath());
                }
                //print_r($this->config['common']['defaultModule']);
                //exit;
            }

            // print_r($module);
            // exit;
            $module = Bootstrap::formatPath($module);
            $path = MODULE_ROOT . SEP . $module;
            if (! file_exists($path)) {
                throw new Exception(t('Cannot find module: @name', 
                array('@name' => $module)));
            }
            $this->module = $module;
        }

        return $this->module;
    }
    
    /**
     * 获取控制器实例
     * 
     * @param array $args 传给控制器的参数
     * @return \System\Controller 控制器实例
     * @throws Exception 404
     */
    public function getController($args = array()) {
        // 模块部分
        $module = str_replace('\\', '/', $this->getModule());
        $prefix = $module ? "Module\\{$module}" : 'Application';
        // 反射实例
        $reflection = null;

        // 手动路由
        if (! empty($this->routingRule)) {
            $this->controllerName = $this->routingRule[1];
            $this->controllerSegments = $this->routingRule[1];
            $this->controllerNS = "{$prefix}\\Controller\\{$this->controllerSegments}";

            try {
                $reflection = new \ReflectionClass($this->controllerNS);
            } catch (Exception $e) {

            }
        }

        // 自动路由
        if ($reflection === null) {
            $defaultController = ucfirst($this->config['common']['defaultController']);
            $controller = '';


            $path = preg_replace('#^(' . $module . '/?)#i', '', $this->parsedPath);
            $parts = explode('/', $path);


            // 递归地址段
            foreach ($parts as $index => & $part) {
                $part = ucfirst($part);
                // 查找控制器
                $this->controllerSegments = implode('\\', array_slice($parts, 0, $index + 1));

                $this->controllerNS = "{$prefix}\\Controller\\{$this->controllerSegments}";
                //print_r($this->controllerSegments);
                try {
                    $reflection = new \ReflectionClass($this->controllerNS);
                    $controller = $this->controllerSegments;
                    break;
                } catch (Exception $e) {

                }
            }

            // 查找默认控制器
            if ($reflection === null) {
                foreach ($parts as $index => $part) {
                    // 查找路径下的默认控制器
                    $this->controllerSegments = implode('\\', array_slice($parts, 0, $index));
                    $controller = $this->controllerSegments !== ''
                        ? "{$this->controllerSegments}\\{$defaultController}"
                        : $defaultController;
                    $this->controllerNS = "{$prefix}\\Controller\\{$controller}";
                    try {
                        $reflection = new \ReflectionClass($this->controllerNS);
                        break;
                    } catch (Exception $e) {
                        $controller = '';
                    }
                }
            }

            $this->controllerName = $controller;

        }

        if ($reflection !== null) {
            return $reflection->newInstanceArgs($args);
        } else {
            throw new Exception(t('Controller \'@ns\' cannot be found.',
                array('@ns' => $this->controllerNS)), 404);
        }
    }
    
    /**
     * 获取控制器名称
     */
    public function getControllerName() {
        return $this->controllerName;
    }
    
    /**
     * 获取当前操作
     * 
     * @return string 当前操作名
     */
    public function getAction() {
        if (! empty($this->routingRule)) {
            $this->action = $this->routingRule[2];

        }
        if ($this->action === '') {
            $module = str_replace('\\', '/', $this->getModule());
            //print_r($module);
            $controller = str_replace('\\', '/', $this->controllerSegments);
            $path = preg_replace(
                '#^(' . $module . '/?(' . $controller . ')?/?)#i', '',
                $this->parsedPath, -1, $count);
            $count === 0 && $path = '';
            $parts = explode('/', $path);

            $this->action = ! empty($parts[0])
                ? $parts[0] 
                : $this->config['common']['defaultAction'];
        }
        return $this->action;
    }
    
    /**
     * 运行线程
     * 
     * @param array $args 运行参数
     * @return mixed 运行结果
     */
    public function run($args = array()) {

        $args = merge_options($this->args, $args);
        //print_r(array($args));
        //exit;
        $controller = $this->getController(array($args));
        $action     = $this->getAction();

        if (method_exists($controller, $action) ||
            method_exists($controller, '__call')) {
            return call_user_func_array(array($controller, $action), array($args));
        }
        throw new Exception(
            t('Action \'@action\' cannot be found.', 
            array('@action' => $this->controllerNS . '::' . $action . '()')),
        404);
    }
}