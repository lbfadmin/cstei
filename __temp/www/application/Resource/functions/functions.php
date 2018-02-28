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
 * @param $text
 * @param array $args
 * @param string|null $domain
 * @param string $language
 * @return string
 */
function translate($text, $args = [], $domain = null, $language = '') {
    $translator = DI()->get('translator');
    return $translator->translate($text, $args, $domain, $language);
}

function pretty_time($time = NULL) {
    $text = '';
    if (!is_numeric($time)) {
        $time = strtotime($time);
    }
    $time = $time === NULL || $time > time() ? time() : intval($time);
    $t = time() - $time; //时间差 （秒）
    $y = date('Y', $time)-date('Y', time());//是否跨年
    switch($t){
        case $t == 0:
            $text = translate('刚刚');
            break;
        case $t < 60:
            $text = translate('@second秒前', ['@second' => $t]); // 一分钟内
            break;
        case $t < 60 * 60:
            $text = translate('@minutes分钟前', ['@minutes' => floor($t / 60)]); //一小时内
            break;
        case $t < 60 * 60 * 24:
            $text = translate('@hours小时前', ['@hours' => floor($t / (60 * 60))]); // 一天内
            break;
        case $t < 60 * 60 * 24 * 3:
            $text = floor($time/(60*60*24)) ==1 ?
                translate('昨天') . ' ' . date('H:i', $time) :
                translate('前天') . ' ' . date('H:i', $time) ; //昨天和前天
            break;
        case $t < 60 * 60 * 24 * 30:
            $text = date(translate('m月d日 H:i'), $time); //一个月内
            break;
        case $t < 60 * 60 * 24 * 365&&$y==0:
            $text = date(translate('m月d日'), $time); //一年内
            break;
        default:
            $text = date(translate('Y年m月d日'), $time); //一年以前
            break;
    }

    return $text;
}

function html_attr_json($data) {
    return str_replace("'", '&apos;', json_encode($data));
}
