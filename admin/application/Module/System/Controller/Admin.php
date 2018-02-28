<?php

namespace Module\System\Controller;

use Module\Account\Controller\Auth;
use System\Component\Validator\Validator;
use System\Component\Crypt;
use Module\System\Model;
use System\Loader;

/**
 * 管理员管理
 * Class Admin
 * @package Module\System\Controller
 */
class Admin extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return array(
            '__ALL__' => 'SYSTEM_ADMIN_MANAGE',
        );
    }

    /**
     * @path 首页
     */
    public function index()
    {
        $modelAdmin = new Model\UserModel();
        $modelRole = new Model\RoleModel();
        $modelUserRole = new Model\UserRoleModel();
        $users = $modelAdmin->getAll([
            'fields' => 'uid,name,email,tel,status,timeCreated'
        ]);

        $roles = [];
        $userIds = [];
        foreach ($users as & $item) {
            $userIds[$item->uid] = $item->uid;
        }
        $userRoles = $modelUserRole->getAll([
            'userIds' => $userIds
        ]);
		// print_r($userRoles);
		// exit;
        if ($userRoles) {
            $roleIds = $userRoleMap = [];
            foreach ($userRoles as & $item) {
                $userRoleMap[$item->userId] = $item->roleId;
                $roleIds[$item->roleId] = $item->roleId;
            }
            $rolesResult = $modelRole->getAll();
            foreach ($rolesResult as & $item) {
                $roles[$item->id] = &$item;
            }
            foreach ($users as & $item) {
                $role = $roles[$userRoleMap[$item->uid]];
                $item->roleName = $role->name;
                $item->roleId = $role->id;
            }
        }
        $this->view->admins = $users;
        $this->view->roles = $roles;
        $this->view->render('system/admin/index');
    }

}