<?php

namespace Module\System;

use System\Bootstrap;
use System\Loader;

class Hooks {
    
    /**
     * Global config reference.
     * @var array
     */
    private $config = array();
    
    public function __construct() {
        $this->config = Bootstrap::getConfig();
    }

    /**
     * Implement hook: beforeViewRender
     */
    public function beforeViewRender($view) {
        $result = Bootstrap::call(
            'system/api/menu/getTree',
            array('export' => 'raw')
        );
        $view->menus = $result['content'];
    }

}