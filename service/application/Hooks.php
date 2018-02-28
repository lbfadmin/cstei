<?php

namespace Application;

use Application\Component\Io\Oss;
use Elasticsearch\ClientBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use System\Bootstrap;
use System\Controller;
use System\Loader;
use System\Component\Db;
use Application\Component\View;

class Hooks {
    
    /**
     * Global config reference.
     * @var array
     */
    private $config = array();

    /**
     * @var \System\Component\Db\Mysql
     */
    private $db = null;

    /**
     * Implement hook: beforeSystemInit()
     */
    public function beforeSystemInit($app) {
        date_default_timezone_set('Asia/Shanghai');
        // PHP ini set on-the-fly.
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL ^ E_NOTICE);
        
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

        // 全局配置
        $bootstrap->setGlobal('config', $this->config);

        $di = new ContainerBuilder();
        $bootstrap->setGlobal('di', $di);

        // db
        $di->register('db', Db\Mysql::class)
            ->addArgument($this->config['Mysql']['main']);

        // event-dispatcher
        $di->register('dispatcher', EventDispatcher::class);

        // elasticsearch
        $di->register('elasticsearch')
            ->setFactory('Application\Hooks::getElasticsearchInstance')
            ->addArgument($this->config['Elasticsearch']['main']);

        // OSS
        $config = $this->config['Oss']['main'];
        $di->register('oss.main', Oss::class)
            ->addArgument($config);
    }

    /**
     * 获取es实例
     * @return \Elasticsearch\Client|null
     */
    public static function getElasticsearchInstance($config) {
        try {
            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->build();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Implement hook: onControllerInit()
     */
    public function onControllerInit(Controller $controller) {
        $thread = $controller->thread;
        $controller->request = $thread->request;
        $controller->response = $thread->response;
    }

    /**
     * Implement hook: beforeViewRender
     */
    public function beforeViewRender(View\AppView $view) {
        $thread = $view->thread;
        $view->href       = $thread->request->href();
        $view->path       = $thread->request->getPath();
        $view->rawPath    = $thread->request->getRawPath();
        $view->module     = $thread->getModule();
        $view->controller = $thread->getController();
        $view->action     = $thread->getAction();
        $view->queries    = $thread->request->getQueries();
    }

}
