<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-11-30
 * Time: 下午2:04
 */

/**
 * @return Symfony\Component\DependencyInjection\ContainerBuilder
 */
function DI() {
    return \System\Bootstrap::getGlobal('di');
}

/**
 * 获取数组/对象下标值，不存在则返回null
 * @param $data
 * @param $key
 * @param $default
 * @return mixed|null
 */
function value(&$data, $key, $default = null) {
    if (is_array($data)) {
        return isset($data[$key]) ? $data[$key] : $default;
    }
    if (is_object($data)) {
        return isset($data->{$key}) ? $data->{$key} : $default;
    }
    return $default;
}

function xml_escape(&$str) {
    $str = preg_replace('#(<br\W*/?>)#i', "\n", $str);
    $str = preg_replace(
        ['#&(?!(amp;|lt;|gt;|apos;|quot;))#i', '#<#', '#>#'],
        ['&amp;', '&lt;', '&gt;'],
        $str
    );
    $str = preg_replace('#(\\r\\n|\\r|\\n)#i', '&#x000D;', $str);
    return $str;
}

function word_xml_escape(&$str) {
    $str = preg_replace('#(<br\W*/?>)#i', "\n", $str);
    $str = preg_replace(
        ['#&(?!(amp;|lt;|gt;|apos;|quot;))#i', '#<#', '#>#'],
        ['&amp;', '&lt;', '&gt;'],
        $str
    );
    $str = preg_replace('#(\\r\\n|\\r|\\n)#i', '<w:br w:type="textWrapping"/>', $str);
    return $str;
}

