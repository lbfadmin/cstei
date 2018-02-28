<?php

namespace Application\Controller;

use Application\Component\Message\Session;
use Application\Component\Util\Api;
use Joomla\Input\Input;
use Module\Account\Component\Account;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use System\Bootstrap;
use Application\Component\View;
use System\Exception;
use System\Loader;

/**
 * 前端控制器
 *
 * 初始化系统变量等
 *
 * @property-read Input $input
 * @property View\AppView $view
 * @property Api $api
 */
class Front extends \System\Controller
{

    protected $fields = [];

    /**
     * @var ContainerBuilder
     */

    protected $di = null;

    /**
     * @var Account\Auth|null
     */
    protected $auth = null;

    /**
     * @var null|object
     */
    protected $user = null;

    public function __construct()
    {
        parent::__construct();

        if ($this->request->getPath() === '') {
            $this->response->redirect('dashboard');
        }

        // input
        $this->di->register('input', 'Joomla\Input\Input');

        // view
        $this->di
            ->register('view', 'Application\Component\View\AppView')
            ->addArgument($this->config['View']);

        $this->auth = new Account\Auth();
        $this->permission = new Account\Permission($this->auth->user);
        $this->message = new Session();
        $this->user =  &$this->auth->user;
        $this->view->_USER = $this->auth->user;
        $this->view->_CONFIG = $this->config;
        $this->view->_TPL = Loader::load('Application\Config\template');
        $this->view->input = $this->input;
    }

    public function __get($name)
    {
        if ($this->di->has($name)) {
            return $this->di->get($name);
        } elseif (!empty(Bootstrap::getGlobal($name))) {
            return Bootstrap::getGlobal($name);
        } else {
            throw new Exception('未定义的属性：' . $name);
        }
    }

    /**
     * 错误页
     * @param $message
     * @param $code
     */
    protected function error($message, $code = 500)
    {
        $this->view->message = $message;
        try {
            $this->view->render('common/' . $code);
        } catch (\Exception $e) {
            $this->view->render('common/error');
        }
        exit(0);
    }

    /**
     * 快捷调用路径
     *
     * @param string $path 要调用的路径
     * @param array $args 参数
     * @return mixed
     */
    public function call($path, $args = array())
    {
        $args['export'] = 'raw';
        return parent::call($path, $args);
    }

    /**
     * 数据预处理
     * @param $data
     * @param array $fields
     */
    protected function preProcessData(& $data, $fields = [])
    {
        $fields = array_merge($this->fields, $fields);
        if (!empty($data)) {
            if (empty($fields)) {
                foreach ($data as $k => & $v) {
                    $v = trim($v);
                }
            } else {
                foreach ($data as $k => & $v) {
                    if (!in_array($k, $fields)) {
                        unset($data[$k]);
                    } else {
                        $v = trim($v);
                    }
                }
            }
        }
    }
}