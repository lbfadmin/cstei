<?php

namespace Module\Account\Component\Account;


use Module\Account\Model\RoleModel;
use Module\Account\Model\UserRoleModel;

class Permission {

    private $user = null;
    
    private $permissions = array();
    
    private $permissionNames = array();
    
    private $isSuperUser = false;
    
    public function __construct($user) {
        $this->user = & $user;
        if ($user->uid == 0) {
            return;
        }
        if ($user->uid == 1) {
            $this->isSuperUser = true;
            return;
        }
        $modelRole = new RoleModel();
        $modelUserRole = new UserRoleModel();
        $userRoleQuery = $modelUserRole->getAll([
            'userId' => $user->uid
        ]);
        $userRole = [];
        if ($userRoleQuery) {
            foreach ($userRoleQuery as & $item) {
                $userRole[$item->roleId] = $item->roleId;
            }
        }
        $this->permissions = $modelRole->getPermissionDetails($userRole);
		
		// print_r($this->permissions);
		// exit;		
        if ($this->permissions) {
            foreach ($this->permissions as $v) {
                 $this->permissionNames[$v->name] = $v->name;
            }
        }
    }
    
    /**
     * 检查权限
     *
     * 支持AND(&,&&) OR(|,||)运算符计算
     * 
     * @param string $permissions 权限规则
     * @return bool 检查结果
     */
    public function check($permissions) {
		
		// print_r($permissions);
		// exit;
        $result = false;
        if (! $permissions || $this->isSuperUser) {
            return true;
        }
        if (! preg_match('#^[A-Z_]+$#', $permissions)) {
            return false;
        }
        if (! $this->permissionNames) {
            return false;
        }
        $permList = $this->permissionNames;
		// exit;
        // 找出权限并验证
        $expression = preg_replace_callback(
            '#[a-zA-Z_]+#is',
            function($m) use (& $permList) {
                return (int) in_array($m[0], $permList);
            },
            $permissions
        );
        // 替换单个的运算符
        $expression = preg_replace('#(?<!&)&(?!&)#i', '&&', $expression);
        $expression = preg_replace('#(?<!\|)\|(?!\|)#i', '||', $expression);
	
        // 执行表达式
        eval('$result = (bool) ' . $expression . ';');

        return $result;
    }
}
