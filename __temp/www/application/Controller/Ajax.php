<?php

namespace Application\Controller;

use Application\Component\Io;
use Psr\Log\LogLevel;
use System\Bootstrap;
use System\Component\Util\StringUtil;

class Ajax extends Front {

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

        if (method_exists($this, 'init')) {
            $this->init();
        }		
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
        );
        // log
        if ($this->config['log']['api'] &&
            !preg_match('#^log/(apiLogger|api-logger)#i', $this->thread->getPath())) {

        }
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

        } catch (\Exception $e) {

        }

        Io\Output::export($export, ['export' => 'json']);
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

        return $response;
    }
}