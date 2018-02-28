<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

class RolePermissionModel extends BaseModel {

    protected $table = '{role_permission}';

    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'roleId' => 0,
            'key'    => null
        ], $params);
        $conds = '';
        $binds = [];
        $return = [];
        if ($params['roleId']) {
            $conds .= " AND roleId = ?";
            $binds[] = $params['roleId'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        $result = $this->db->fetchAll($sql, $binds);
        if ($result && $params['key']) {
            foreach ($result as & $item) {
                $return[$item->{$params['key']}] = & $item;
            }
        } else {
            $return = & $result;
        }
        return $return;
    }

}