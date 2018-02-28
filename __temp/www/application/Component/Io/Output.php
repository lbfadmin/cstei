<?php

namespace Application\Component\Io;

use System\Bootstrap;
use System\Component\Http;
use Application\Component\View;

/**
 * 输出指定格式的数据
 * Class Output
 * @package Application\Component\Io
 */
class Output {
    
    private static $options = array(
        'export'        => 'json',
        'jsonp'         => 'callback',
        'jsonpCallback' => '',
        'raw'           => 0
    );

    /**
     * 输出结果
     * 
     * @param mixed $data 结果集
     * @param array $options 选项
     * @return void|mixed
     */
    public static function export($data = null, $options = array()) {
        $options = array_merge(self::$options, $options);
        switch ($options['export']) {
            // json
            case 'json':
                Http\Response::json($data, null);
                break;
            // jsonp
            case 'jsonp':
                $callback = $options['jsonpCallback'] ?: $_GET[$options['jsonp']];
                echo $callback . '(' . json_encode($data, JSON_UNESCAPED_UNICODE) . ')';
                break;
            // php
            default:
                return $data;
        }
    }

}