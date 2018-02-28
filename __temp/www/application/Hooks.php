<?php

namespace Application;

use Application\Component\Util\Api;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use System\Bootstrap;
use System\Component\Locale\Locale;
use System\Controller;
use System\Loader;
use System\Component\Db;
use System\Component\Cache;
use System\Component\Session;
use System\Component\Message;
use System\Component\Http;
use Application\Component\View;
use System\Component\Util;

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
        //ini_set('error_reporting', E_ALL);

        // Session config.
        ini_set('session.gc_maxlifetime', 604800); // one week
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 25);
        ini_set('session.name', 'lucasgchr');
        // ini_set('session.save_handler', 'user');
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        
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

        $di->register('api', 'Application\Component\Util\Api')
            ->addArgument($this->config['service']);

        // 全局配置
        $bootstrap->setGlobal('config', $this->config);

        $bootstrap->setGlobal('di', $di);

        session_start();
    }

    /**
     * Implement hook: onControllerInit()
     */
    public function onControllerInit(Controller $controller) {
        $thread = $controller->thread;
        $controller->request = $thread->request;
        $controller->response = $thread->response;
        $controller->message = new Message\Session;
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
        // 消息
        if (! empty($_SESSION['messages'])) {
            $view->messages = Message\Session::render();
        }
    }

}
