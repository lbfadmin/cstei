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

class Locale {
    
    /**
     * Locale options.
     * @var array
     */
    private static $options = array(
        'queryString'     => 'l',
        'defaultLanguage' => 'en'
    );
    
    /**
     * Current language.
     * @var string
     */
    private static $language = '';
    
    /**
     * Set locale options.
     * 
     * @param array $options
     */
    public static function setOptions(array $options) {
        self::$options = array_merge(self::$options, $options);
    }

    public static function setLanguage($language) {
        self::$language = $language;
    }
    
    /**
     * Get current language.
     * 
     * @return string language code
     */
    public static function getLanguage() {
        if (self::$language === '') {
            $queryString = self::$options['queryString'];
            self::$language = isset($_GET[$queryString])
                ? $_GET[$queryString]
                : self::$options['defaultLanguage'];
        }
        
        return self::$language;
    }
}
