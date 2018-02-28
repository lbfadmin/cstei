<?php

namespace Module\Account\Controller;

class Api extends \Application\Controller\Api {

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