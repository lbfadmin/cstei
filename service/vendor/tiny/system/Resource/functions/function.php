<?php

/**
 * xframework - 敏捷高效的php框架
 *
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

use System\Bootstrap,
    System\Component\Locale,
    System\Component\Http;

/**
 * Get microtime.
 */
function timer() {
    list($usec, $sec) = explode(' ', microtime());

    return ((float)$usec + (float)$sec);
}

/**
 * Creat directory parent to child
 *
 * @param $path
 * @param $mode
 */
function mkdirs($path, $mode = 0777) {
    $dirs = explode('/',$path);
    for ($i = 0; $i < count($dirs); $i++) {
        $thispath = '';
        for ($n = 0; $n <= $i; $n++) {
            $thispath .= $dirs[$n] . '/';
        }
        if (!file_exists($thispath)) {
            @mkdir($thispath, $mode);
            chmod($thispath, 0777);
        }
    }
}

/**
 * Record logs
 *
 * @param $type
 * @param $message
 * @param $severity
 * @param $file
 * @param $path
 * @return true/false
 */
function _log($type, $message, $severity = L_NOTICE, $file = '', $path = '') {

    $file = $file ? $file : date("Y-m-d") . '.log';

    $path = $path ? $path : ROOT . '/logs/' . date("Y-m-d");
    if (!file_exists($path)) {
        mkdirs($path);
    }
    $log = array(
        'type'     => $type,
        'time'     => date("Y-m-d H:i:s"),
        'message'  => $message,
        'severity' => $severity
    );
    $log = implode('|', $log) . "\r\n";
    $f = file_put_contents($path . '/' . $file, $log, FILE_APPEND);
    $per = fileperms ($path . '/' . $file);
    $per = substr($per, -4);
    //judge the permission
    if($per != 3279){
        chmod($path . '/' . $file,0777);
    }


    if ($f) {
        return true;
    } else {
        return false;
    }
}

/**
 * Merge options recursively
 *
 * @param  array $array1
 * @param  mixed $array2
 * @return array
 */
function merge_options(array $array1, $array2 = NULL) {
    if (is_array($array2)) {
        foreach ($array2 as $key => $val) {
            if (is_array($array2[$key])) {
                $array1[$key] = (array_key_exists($key, $array1) && is_array($array1[$key])) ?
                    merge_options($array1[$key], $array2[$key]) :
                    $array2[$key];
            } else {
                $array1[$key] = $val;
            }
        }
    }

    return $array1;
}

/**
 * Shortcut of \System\Component\Locale\Translator::translate().
 *
 * @see \System\Component\Locale\Translator::translate()
 */
function t($text, $args = array(), $domain = '', $language = '') {
    return Locale\Translator::translate($text, $args, $domain, $language);
}


/**
 * Returns an internal path.
 *
 * Some examples:
 *  url('user/login')
 *      /user/login
 *  url('user/login', array('absolute' => true))
 *       http(s)://{baseDomain}/user/login
 *  url('/user/login')
 *      /user/login
 *  url('user/login', array('query' => array('q' => 'abc')))
 *      /user/login?q=abc
 *
 * @param string $path
 * @param array $options
 * @return string
 */
function url($path = '', $options = array()) {
    $config = Bootstrap::getConfig();
    // External path.
    if (preg_match('#^http[s]?://#', $path)) {
        return $path;
    }
    $options += array(
        'fragment'  => '',
        'query'     => array(),
        'absolute'  => false,
    );
    if (! $path || $path === '<front>') {
        $path = $config['common']['frontPage'];
    }
    $base = $options['baseUrl'] ?: Http\Request::baseUrl();
    if ($options['fragment']) {
        $options['fragment'] = '#' . $options['fragment'];
    }
    $q = array();
    if ($options['query']) {
        foreach ($options['query'] as $k => $v) {
            $q[] = $k . '=' . $v;
        }
    }
    $q = implode('&', $q);

    // url rewrite ?
    $url = $config['common']['urlRewrite']
        ? $path . ($q ? '?' . $q : '')
        : $_SERVER['SCRIPT_NAME'] . '?p=' . $path . ($q ? '&' . $q : '');
    $url = $url . $options['fragment'];
    if (preg_match('#^/#', $path)) {
        return $url;
    }
    if ($options['absolute'] === true) {
        $url = preg_match('#/$#', $base) ? $base . $url : $base . '/' . $url;
    } else {
        $url = '/' . $url;
    }

    return $url;
}

/**
 * Shortcut for Response::redirect()
 */
function redirect($url, $options = array(), $time = 0) {
    Http\Response::redirect($url, $options, $time);
}

/**
 * Refresh current page.
 */
function refresh() {
    $url = Http\Request::urlInfo();
    redirect($url['path'], array('query' => $url['query']));
}
 