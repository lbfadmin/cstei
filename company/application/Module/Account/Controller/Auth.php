<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-4-18
 * Time: 下午4:52
 */

namespace Module\Account\Controller;


use Application\Controller\Front;

class Auth extends Front
{

    /**
     * 忽略认证的action
     * @var array
     */
    protected $ignoreAuth = array();

    /**
     * 权限
     * @var array
     */
    protected $permissions = [];

    public function __construct()
    {
        parent::__construct();

        $action = $this->thread->getAction();
        if (! in_array($action, $this->ignoreAuth) && ! $this->auth->isLogin()) {

            $ref = $this->request->href();

            $this->response->redirect(url('account/login', ['query' => ['ref' => $ref]]));
        }
		// print_r($_SESSION['user']);
		// print_r($_SESSION['user']);
		// exit;
        // 检查权限
        if (method_exists($this, 'permission')) {
            $perms = $this->permission();
            $this->permissions = array_merge($this->permissions, $perms);
            $action = $this->thread->getAction();
            if (isset($this->permissions['__ALL__'])) {
                $action = '__ALL__';
            }
            if (isset($this->permissions[$action])) {
                $result = $this->permission->check($this->permissions[$action]);
                if (! $result) {
                    $this->error('您没有权限进行此操作', 403);
                }
            }
        }
    }
}