<?php

namespace Application\Controller;

use Application\Component\Locale\Translator;
use Application\Component\Util\Variable;
use Joomla\Input\Input;
use Module\Account\Component\Account;
use Module\Locale\Model\LanguageModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Elasticsearch\Client;
use System\Bootstrap;
use System\Component\Cache;
use System\Component\Http;
use System\Component\Locale\Locale;
use System\Component\Message;
use Application\Component\View;
use System\Component\Queue\Redis\RedisQueue;
use System\Exception;
use System\Loader;
use System\Component\Log;
use Predis;

/**
 * 前端控制器
 * 
 * 初始化系统变量等
 *
 * @property-read Input $input
 * @property View\AppView $view
 * @property-read Log\Mysql $logger
 */
class Front extends \System\Controller {

    /**
     * @var ContainerBuilder
     */
    protected $di = null;

    public function __construct() {
        parent::__construct();
        // input
        $this->di->register('input', 'Joomla\Input\Input');

        // view
        $this->di
            ->register('view', 'Application\Component\View\AppView')
            ->addArgument($this->config['View']);

        $this->view->_CONFIG = $this->config;
    }

    public function __get($name) {
        if ($this->di->has($name)) {
            return $this->di->get($name);
        } elseif (! empty(Bootstrap::getGlobal($name))) {
            return Bootstrap::getGlobal($name);
        } else {
            throw new Exception('未定义的属性：' . $name);
        }
    }

    /**
     * 快捷调用路径
     * 
     * @param string $path 要调用的路径
     * @param array $args 参数
     * @return mixed
     */
    public function call($path, $args = array()) {
        $args['export'] = 'raw';
        return parent::call($path, $args);
    }

    /**
     * 数据预处理
     * @param $data
     * @param array $fields
     */
    protected function preProcessData(& $data, $fields = []) {
        $fields = array_merge($this->fields, $fields);
        if (! empty($data)) {
            if (empty($fields)) {
                foreach ($data as $k => & $v) {
                    $v = trim($v);
                }
            } else {
                foreach ($data as $k => & $v) {
                    if (! in_array($k, $fields)) {
                        unset($data[$k]);
                    } else {
                        $v = trim($v);
                    }
                }
            }
        }
    }
}