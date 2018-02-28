<?php

namespace Module\Account\Model;

use Application\Model\BaseModel;

class UserRoleModel extends BaseModel {

    protected $table = '{user_role}';
    
    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'userId' => 0,
            'roleId' => 0,
            'userIds' => [],
            'key'    => null
        ], $params);
        $conditions = '';
        $binds = [];
        $return = [];
        if ($params['userId']) {
            $conditions .= " AND userId = ?";
            $binds[] = $params['userId'];
        }
        if ($params['roleId']) {
            $conditions .= " AND roleId = ?";
            $binds[] = $params['roleId'];
        }
        if ($params['userIds']) {
            $ids = implode(',', $params['userIds']);
            $conditions .= " AND userId IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
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