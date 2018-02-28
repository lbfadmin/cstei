<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Locale;

use System\Bootstrap;
use System\Loader;

class Translator {
    
    /**
     * Translator options.
     * @var array
     */
    private static $options = array(
        'domain' => ''
    );
    
    /**
     * Cached resources.
     * @var array
     */
    private static $resources = array();
    
    /**
     * Set translator options.
     */
    public static function setOptions(array $options) {
        self::$options = $options;
    }
    
    /**
     * Translator
     * 
     * System will find such file in path:
     * PATH_TO_LANGUAGE/[language]/[domain].php
     * 
     * @param string $text
     * @param array $args
     * @param string $domain Domain prefix
     * @param string $language Language code
     * @return string
     */
    public static function translate($text, $args = array(), $domain = '', $language = '') {
        $language = $language ?: Locale::getLanguage();
        $resource = self::getResources($language, $domain);
        $string = (empty($resource) || ! isset($resource[$text])) ? $text : $resource[$text];
    
        return strtr($string, $args);
    }
    
    /**
     * Get language resource
     * 
     * For example:
     *     /Application/Resource/languages/zh/user.php
     * 
     * @param string $language Language code
     * @param string $domain Domain prefix
     * @return array Language resource.
     */
    public static function getResources($language, $domain = '') {
        $domain = $domain ?: self::$options['domain'] ?: $language;
        $base = 'Resource/languages/' . $language . '/' . $domain;
        if (! isset(self::$resources[$base])) {
            $resource = array();
            // 系统资源.
            $resource = Loader::load('System/' . $base) ?: $resource;
            // 程序资源.
            if ($_resource = Loader::load('Application/' . $base)) {
                $resource = array_merge($resource, $_resource);
            }
            // 模块资源.
            $module = Bootstrap::getModule();
            if ($module && $_resource = Loader::load("Module\\{$module}\\{$base}")) {
                $resource = array_merge($resource, $_resource);
            }
            self::$resources[$base] = $resource;
        }
        
        return self::$resources[$base];
    }
}
