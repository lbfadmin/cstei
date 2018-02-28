<?php
 
/**
 * view.php
 * 
 * @author xlight <i@im87.cn>
 * @version 2.0
 */

namespace System\Component\View;

use System\Bootstrap;
use System\Exception;
use System\Loader;
use System\Component\Http\Response;
use System\Thread;

class View {
    
    /**
     * Defined variables.
     * @var array
     */
    protected $variables   = array();
    
    /**
     * Registered helpers.
     * @var array
     */
    private static $helpers = array();
    
    /**
     * 活动线程
     * @var Thread
     */
    public $thread = null;
    
    /**
     * View options.
     * @var array
     */
    protected static $options = array(
        'theme'        => 'default',
        'charset'      => 'utf-8',
        'contentType'  => 'text/html',
        'extension'    => '.tpl.php'
    );
    
    /**
     * Constructor.
     * 
     * @param array $options
     */
    public function __construct($options = array()) {
        $this->thread = Bootstrap::getActiveThread();
        self::setOptions($options);
        $this->registerHelper('block', '\System\Component\View\Helper\Block');
        $this->registerHelper('form', '\System\Component\View\Helper\Form');
        // Invoke hook: onViewInit()
        Bootstrap::invokeHook('onViewInit', $this);
    }

    /**
     * 动态定义变量
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->variables[$name] = $value;
    }

    /**
     * 获取变量
     * @param $name
     * @return mixed|null
     */
    public function __get($name) {
        return isset($this->variables[$name]) ? $this->variables[$name] : null;
    }

    /**
     * 使用助手方法
     * 
     * @param string $name Helper name.
     * @return object Helper instance.
     */
    public function __call($name, $args) {
        return $this->getHelper($name, $args);
    }

    /**
     * 设置选项
     * 
     * @param array $options
     */
    public static function setOptions(array $options) {
        self::$options = array_merge(self::$options, $options);
    }
    
    /**
     * 定义变量
     * 
     * @param string|array $name
     * @param mixed $value
     */
    public function assign($name, $value = null) {
        if (is_array($name)) {
            $this->variables = array_merge($this->variables, $name);
        } elseif (is_object($name)) {
            foreach($name as $key => $val)
                $this->variables[$key] = $val;
        } else {
            $this->variables[$name] = $value;
        }
    }
    
    /**
     * 渲染视图
     * 
     * @param string $file template file.
     * @param string $theme
     * @param array $sets settings.
     */
    public function render($file = '', $theme = '', $sets = array()) {
        // Invoke hook: beforeViewRender()
        Bootstrap::invokeHook('beforeViewRender', $this);
        $contentType = isset($sets['contentType'])
            ? $sets['contentType']
            : self::$options['contentType'];
        $charset = isset($sets['charset'])
            ? $sets['charset']
            : self::$options['charset'];
        header("Content-Type:" . $contentType . "; charset=" . $charset);
        Response::sendHeader();
        echo $this->fetch($file, $theme);
        // Invoke hook: onViewRender()
        Bootstrap::invokeHook('onViewRender', $this);
    }
    
    /**
     * 获取视图内容
     * 
     * @param string $name
     * @param string $theme
     * @param array $sets
     * @return string Page content.
     */
    public function fetch($name = '', $theme = '') {
        $tpl = $this->getTemplate($name, $theme);
        ob_start();
        ob_implicit_flush(0);
        extract($this->getVariables(), EXTR_REFS);
        include $tpl;

        return ob_get_clean();
    }
    
    /**
     * 获取视图文件
     * 
     * @param string $name
     * @param string $theme
     * @return string
     * @throws Exception
     */
    public function getTemplate($name, $theme = '') {
        $theme = $theme ?: self::$options['theme'];
        $theme = $theme ? $theme . "\\" : $theme;
        $name = trim(str_replace('/', "\\", $name));
        $path = '';
        if (substr($name, 0, 1) === ':') {
            $module = $this->thread->getModule();
            $path .= "Module\\{$module}";
        }
        if (strstr($name, ':')) {
            $path .= str_replace(':', "\\Resource\\views\\{$theme}", $name);
        } else {
            $path = $name;
        }
        $file = Loader::find($path, self::$options['extension']);
        if ($file) {
            return $file;
        }
        throw new Exception(t('Cannot find template: @path', array('@path' => $path)));
    }

    /**
     * 获取变量
     * 
     * @return array Variables.
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * 模板中是否存在某变量
     * @param $name
     * @return bool
     */
    public function hasVariable($name)
    {
        return isset($this->variables[$name]);
    }
    
    /**
     * 引入视图区域
     * 
     * @param string $name
     * @param array $variables
     * @param string $theme
     */
    public function region($name, $variables = array(), $theme = '') {
        // 防止命名冲突
        extract($this->getVariables(), EXTR_REFS);
        // Add local variables
        if (! empty($variables)) {
            extract($variables, EXTR_REFS);
        }
        include $this->getTemplate($name, $theme);
    }
    
    /**
     * 获取模板内容
     *
     * @param string $tpl
     * @param string $theme
     * @return string
     */
    public function getContents($tpl, $theme = '') {
        return file_get_contents($this->getTemplate($tpl, $theme));
    }
    
    /**
     * 注册助手
     * 
     * @param string $name
     * @param mixed $helper
     */
    public static function registerHelper($name, $helper) {
        self::$helpers[$name] = $helper;
    }
    
    /**
     * 获取助手
     * 
     * @param string $name
     * @param array $params
     * @return object helper instance
     * @throws Exception
     */
    public function getHelper($name, $params = array()) {
        $helper = self::$helpers[$name];
        if (empty($helper)) {
            throw new Exception(t('Cannot find view helper: @name', array('@name' => $name)));
        }
        if (is_callable($helper)) {
            return call_user_func_array($helper, $params);
        }
        if (is_object($helper)) {
            return $helper;
        }
        if (is_string($helper)) {
            $reflection = new \ReflectionClass($helper);
            return $reflection->newInstanceArgs($params);
        }
    }
}
