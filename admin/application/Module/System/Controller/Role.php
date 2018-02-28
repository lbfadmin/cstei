<?php

namespace Module\System\Controller;

use Module\Account\Controller\Auth;
use Module\System\Model\RoleModel;
use System\Component\Validator\Validator;

/**
 * 角色管理
 * Class Role
 * @package Module\System\Controller
 */
class Role extends Auth
{
    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return array(
            '__ALL__' => 'SYSTEM_ROLE_MANAGE',
        );
    }

    /**
     * @path 首页
     */
    public function index()
    {
        $modelAdminRole = new RoleModel();
        $items = $modelAdminRole->getAll();
        $this->view->roles = $items;
        $this->view->render('system/role/index');
    }
}