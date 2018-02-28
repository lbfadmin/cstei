<?php

namespace Application\Component\View;

use System\Bootstrap;
use System\Loader;
use System\Exception;
use System\Component\View\View;

class AppView extends View {
    
    public $scripts = array();

    private static $imgBaseUrl = '';

    private static $map = null;

    public function __construct() {
        parent::__construct();
        Loader::registerNamespace('Theme', APP_ROOT . '/Resource/themes');
        Loader::registerNamespace('Public', PUBLIC_ROOT);
        $this->config = Bootstrap::getConfig();
        parent::__construct();
        $mapFile = Loader::find('Public\misc\dist\map', '.json');
        if (self::$map === null && $mapFile) {
            self::$map = file_get_contents($mapFile);
            self::$map = json_decode(self::$map, true);
            if (! self::$map || ! is_array(self::$map)) {
                self::$map = array();
            }
        }
    }

    /**
     * 获取视图文件
     *
     * @param string $name
     * @param string $theme
     */
    public function getTemplate($name, $theme = '') {
        $theme = $theme ?: self::$options['theme'];
        $theme = $theme ? $theme . "\\" : $theme;
        $name = trim(str_replace('/', "\\", $name));
        $path = 'Theme\\' . $theme . $name;
        $file = Loader::find($path, self::$options['extension']);
        if ($file) {
            return $file;
        }
        throw new Exception(t('Cannot find template: @path', array('@path' => $path)));
    }

    /**
     * 生成完整图片或缩略图src
     *
     * @param string $object 图片路径
     * @param string $thumb 缩略图规则
     * @return string 完整src
     */
    public static function img($object, $thumb = '') {
        if (substr($object, 0, 1) === '/') {
            return $object;
        }
        if (self::$imgBaseUrl === '') {
            $config = Bootstrap::getConfig();
            self::$imgBaseUrl = $config['common']['imageBaseUrl'];
        }
        $src = preg_match('#http|https#', $object) ? $object : self::$imgBaseUrl . $object;
        if ($thumb) {
            $src = $src . '?' . $thumb;
        }

        return $src;
    }

    /**
     * 格式化输出脚本
     *
     * @param string $path 输入脚本路径
     * @return string 格式化的脚本路径
     */
    public function misc($path) {
        $path = preg_replace('#(\?.*)$#i', '', $path);
        if ($this->config['View']['debug'] || empty(self::$map[$path])) {
            $result = $this->getResourcePath($path);
        } else {
            $result = $this->config['common']['miscBaseUrl'] . self::$map[$path]['dest'];
        }

        return $result;
    }

    private function getResourcePath($path) {
        $real = str_replace("\\", '/', $path);
        if (! preg_match('#^(/|http)#', $real)) {
            $real = preg_replace_callback(
                '#([^:]*:)#',
                array($this, 'formatReplace'),
                $real
            );
            $real = '/misc/src/' . str_replace("\\", '/', $real);
        }
        return $real;
    }

    /**
     * 格式化并替换命名空间
     */
    public function formatReplace($m) {
        // application
        if (preg_match('#^application#i', $m[1])) {
            return 'app/';
        }
        // 当前module
        if (substr($m[1], 0, 1) === ':') {
            $module = $this->thread->getModule();
        }
        // 任意module
        if (preg_match('#^module/([^:]*)#i', $m[1], $m2)) {
            $module = $m2[1];
        }
        return "module/" . strtolower($module) . "/";
    }

}
