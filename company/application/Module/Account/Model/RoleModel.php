<?php

namespace Module\Account\Model;

use Application\Model\BaseModel;

class RoleModel extends BaseModel {

    protected $table = '{role}';

    /**
     * 获取角色权限
     */
    public function getPermissionDetails(array $roleIds) {
        $roleIds = implode(',', $roleIds);
        $sql = "SELECT * "
            . " FROM {role_permission} a"
            . " LEFT JOIN {permission} b ON a.permission = b.name"
            . " WHERE a.roleId IN({$roleIds})";
        return $this->db->fetchAll($sql);
    }
}