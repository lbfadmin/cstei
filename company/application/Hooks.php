<?php

namespace Application;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use System\Bootstrap;
use System\Controller;
use System\Loader;
use System\Component\Db;
use Application\Component\Message\Session;
use Application\Component\View;

class Hooks {
    
    /**
     * Global config reference.
     * @var array
     */
    private $config = array();

    /**
     * Implement hook: beforeSystemInit()
     */
    public function beforeSystemInit($app) {
        date_default_timezone_set('Asia/Shanghai');
        // PHP ini set on-the-fly.
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL ^ E_NOTICE);
//        ini_set('error_reporting', E_ALL);

        // composer autoload
        require ROOT . '/vendor/autoload.php';
    }
    
    /**
     * Implement hook: onSystemInit()
     */
    public function onSystemInit($app) {
        Loader::load('Application\Resource\functions\functions');
    }
    
    /**
     * Implement hook: onApplicationInit()
     */
    public function onApplicationInit(Bootstrap $bootstrap) {

        $this->config = $bootstrap->getConfig();
        
        define('TEMP_DIR', ROOT . '/temp/');

        $di = new ContainerBuilder();

        // 全局配置
        $bootstrap->setGlobal('config', $this->config);

        $bootstrap->setGlobal('di', $di);

        // api
        $di->register('api', 'Application\Component\Util\Api')
            ->addArgument($this->config['service']);

        // mysql
        $di->register('db', 'System\Component\Db\Mysql')
            ->addArgument($this->config['Mysql']['main']);

        $db = $di->get('db');
        Bootstrap::setGlobal('db', $db);

        session_start();
    }

    /**
     * 获取模块
     */
    public function onGettingModules() {
        $modules = array();
        $di = Bootstrap::getGlobal('di');
        /* @var Db\Mysql $db */
        $db = $di->get('db');
        $sql = "SELECT name,path "
            . " FROM {module}";
        $result = $db->fetchAll($sql);
        foreach ($result as $v) {
            $modules[] = $v->path;
        }
        Bootstrap::setModules($modules);
    }

    /**
     * Implement hook: onControllerInit()
     */
    public function onControllerInit(Controller $controller) {
        $thread = $controller->thread;
        $controller->request = $thread->request;
        $controller->response = $thread->response;
        $controller->message = new Session();
    }

    /**
     * Implement hook: beforeViewRender
     */
    public function beforeViewRender(View\AppView $view) {
        $thread = $view->thread;
        $view->href       = $thread->request->href();
        $view->path       = $thread->request->getPath();
        $view->rawPath    = $thread->request->getRawPath();
        if (!isset($view->queries)) {
            $view->queries = $thread->request->getQueries();
        }
        if ($view->activePath == '') {
            $view->activePath = $thread->request->getPath();
        }
    }

}
