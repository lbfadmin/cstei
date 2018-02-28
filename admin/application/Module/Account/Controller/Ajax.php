<?php

namespace Module\Account\Controller;

class Ajax extends \Application\Controller\Ajax {

    /**
     * 忽略认证的action
     * @var array
     */
    protected $ignoreAuth = array();

    public function __construct($args = array()) {
        parent::__construct($args);

        $action = $this->thread->getAction();

        if (! in_array($action, $this->ignoreAuth)
            && ! $this->auth->isLogin()) {
            return $this->export([
                'code' => self::STATUS_SYS_PERMISSION_DENIED
            ]);
        }
    }
}