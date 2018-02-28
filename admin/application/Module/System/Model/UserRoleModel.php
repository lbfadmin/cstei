<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

class UserRoleModel extends BaseModel {

    protected $table = '{user_role}';
    

    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'userId' => 0,
            'userIds' => [],
            'key'    => null
        ], $params);
        $conds = '';
        $binds = [];
        $return = [];
        if ($params['userId']) {
            $conds .= " AND userId = ?";
            $binds[] = $params['userId'];
        }
        if ($params['userIds']) {
            $ids = implode(',', $params['userIds']);
            $conds .= " AND userId IN({$ids})";
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