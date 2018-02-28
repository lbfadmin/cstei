<?php

namespace Application\Controller;

use Application\Component\Util\Variable;
use Joomla\Input\Input;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Elasticsearch\Client;
use System\Bootstrap;
use System\Component\Cache;
use Application\Component\View;
use System\Component\Queue\Redis\RedisQueue;
use System\Exception;
use System\Component\Log;

/**
 * 前端控制器
 *
 * 初始化系统变量等
 *
 * @property-read Input $input
 * @property View\AppView $view
 * @property-read Variable $variable
 * @property-read Cache\Mysql $cache
 * @property-read RedisQueue $queue
 * @property-read Client $elasticsearch
 */
class Front extends \System\Controller
{

    /**
     * mysql
     * @var \System\Component\Db\Mysql
     */
    protected $db = null;

    protected $fields = [];

    /**
     * @var ContainerBuilder
     */

    protected $di = null;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->di->get('db');

        // input
        $this->di->register('input', 'Joomla\Input\Input');

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
                    $v = is_string($v) ? trim($v) : $v;
                }
            } else {
                foreach ($data as $k => & $v) {
                    if (!in_array($k, $fields)) {
                        unset($data[$k]);
                    } else {
                        $v = is_string($v) ? trim($v) : $v;
                    }
                }
            }
        }
    }
}