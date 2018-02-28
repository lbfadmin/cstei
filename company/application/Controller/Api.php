<?php

namespace Application\Controller;

use Application\Component\Io;
use Psr\Log\LogLevel;
use System\Bootstrap;
use System\Component\Util\StringUtil;

class Api extends Front {

    protected $options = array(
        'export'        => 'json',
        'jsonp'         => 'callback',
        'jsonpCallback' => '',
        'raw'           => 0
    );

    /**
     * 状态正常
     */
    const STATUS_OK = 'OK';

    /**
     * 系统错误
     */
    const STATUS_SYS_ERROR = 'SYS.ERROR';

    /**
     * SQL错误
     */
    const STATUS_SYS_SQL_ERROR = 'SYS.SQL_ERROR';

    /**
     * 无权限
     */
    const STATUS_SYS_PERMISSION_DENIED = 'SYS.PERMISSION_DENIED';

    /**
     * 服务不可用
     */
    const STATUS_SYS_SERVICE_UNAVAILABLE = 'SYS.SERVICE_UNAVAILABLE';

    /**
     * 状态消息
     * @var array
     */
    private static $statusMessages = array(
        'OK'                    => '成功',
        'SYS.ERROR'             => '系统错误',
        'SYS.SQL_ERROR'         => '系统错误: SQL执行失败',
        'SYS.PERMISSION_DENIED' => '权限被拒绝',
        'SYS.SERVICE_UNAVAILABLE' => '服务不可用'
    );

    public function __construct($args = array()) {
        parent::__construct();

        $this->options = array_merge($this->options, $args);

        if (! empty($this->config['api']['debug']) && $this->options['export'] !== 'raw') {
            $auth = $this->genAuthCode($this->request->getPath(), $_REQUEST['api_key']);
            if ($auth !== $_REQUEST['authorization']) {
                $this->export([
                    'code' => self::STATUS_SYS_PERMISSION_DENIED
                ]);
            }
        }

        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

    private function genAuthCode($api, $apiKey) {
        $str = $api . ':' . $apiKey . ':' . $this->config['api']['auth'][$apiKey];
        return md5($str);
    }

    /**
     * 输出结果
     * 
     * @param mixed $data 结果集
     * @param array $options 选项
     * @return mixed
     */
    protected function export($data = null, $options = array()) {
        if ($options) {
            $this->options = array_merge($this->options, $options);
        }
        if ($data !== null && ! is_array($data)) {
            $data = (array) $data;
        }
        $data = $this->options['raw']
            ? $data
            : $this->formatExportData($data);
        $timeTaken = Bootstrap::timer() - START_TIME;
        $debug = array(
            'timeTaken'   => $timeTaken . ' s',
            'memoryUsage' => StringUtil::formatSize(memory_get_usage(true)),
            'mysqlQueryDetails' => $this->db->getQueryDetails()
        );
        if ($this->config['common']['debug']) {
            $data['debug'] = $debug;
        }
        return Io\Output::export($data, $this->options);
    }

    /**
     * 异常处理
     * @param $e
     * @return mixed|void
     */
    public static function exceptionHandler($e) {
        $export['code'] = $e['code'];
        $export['message'] = $e['message'];
        $export['data'] = [
            'exception' => $e,
            'server' => $_SERVER,
            'request' => $_REQUEST,
        ];
        $export = self::formatExportData($export);

        try {
            /* @var \Application\Component\Log\MongoLogger $apiLogger */
            $apiLogger = DI()->get('logger.api');
            switch ($e['code']) {
                case 404:
                case 403:
                    $level = LogLevel::WARNING; break;
                default:
                    $level = LogLevel::ERROR;
            }
            $app = Bootstrap::getApplication();
            $apiLogger->log(
                $level,
                $e['message'],
                [
                    'path'     => $app ? $app->getPath() : Bootstrap::getPath(),
                    'app'      => $_REQUEST['api_key'],
                    'code'     => $e['code'],
                    'data'     => $export,
                    'request'  => $_REQUEST,
                    'timeTaken' => Bootstrap::timer() - START_TIME,
                    'memoryUsage' => memory_get_usage(),
                    'memoryAllocated' => memory_get_usage(true)
                ]
            );
        } catch (\Exception $e) {

        }


        return Io\Output::export($export, ['export' => 'json']);
    }

    /**
     * 格式化状态码
     * @param $name
     * @param string $type
     * @return string
     */
    protected function code($name, $type = 'SVC') {
        return $type . '.' . $name;
    }

    /**
     * 消息封装
     * @param $text
     * @return string
     */
    protected function message($text) {
        return $text;
    }

    /**
     * 格式化输出
     *
     * @param mixed $data 待格式化数据
     * @return array 格式化的数据
     */
    public static function formatExportData($data = null) {
        $response = $data;
        $message = '';
        if (! is_array($data)) {
            $response = array('data' => $data);
        }
        if (isset($data['code']) && isset(self::$statusMessages[$data['code']])) {
            $message = self::$statusMessages[$data['code']];
        }
        $message = $message ?: self::$statusMessages['OK'];
        $response = array_merge(array(
            'code'    => 'OK',
            'message' => $message
        ), $response);
        // 消息翻译
        $response['message'] = (
            ($response['code'] === 'OK' && $response['message'] === self::$statusMessages['OK'])
            || substr($response['code'], 0, 3) === 'SYS')
            ? $response['message']
            : translate($response['message']);

        return $response;
    }
}