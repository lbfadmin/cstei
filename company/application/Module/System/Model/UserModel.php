<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

class UserModel extends BaseModel {

    protected $table = '{user}';

    public static $fields = [
        'uid',
        'name',
        'email',
        'tel',
        'pass',
        'salt',
        'status',
        'region',
        'timeCreated'
    ];
    
    public function getItem($params = []) {
        $params = array_merge([
            'fields' => '*',
            'email'  => '',
            'tel'    => '',
            'uid'    => 0,
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['email']) {
            $conditions .= " AND email = ?";
            $binds[] = $params['email'];
        }
        if ($params['tel']) {
            $conditions .= " AND tel = ?";
            $binds[] = $params['tel'];
        }
        if ($params['uid']) {
            $conditions .= " AND uid = ?";
            $binds[] = $params['uid'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " LIMIT 1";
        return $this->db->fetch($sql, $binds);
    }
    
    /**
     * 获取所有
     * 
     * @param string $fields 获取的字段
     * @return array 结果集
     */
    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'region' => 0,
            'tel'    => null,
            'uids'   => null,
            'email'     => null,
            'name'      => '',
            'status'    => 0,
            'key' => 'uid'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['region']) {
            $conditions .= " AND region = ?";
            $binds[] = $params['region'];
        }
        if ($params['email']) {
            $conditions .= " AND email = ?";
            $binds[] = $params['email'];
        }
        if ($params['tel']) {
            $conditions .= " AND tel = ?";
            $binds[] = $params['tel'];
        }
        if ($params['status']) {
            $conditions .= " AND status = ?";
            $binds[] = $params['status'];
        }
        if ($params['uids']) {
            $uids = implode(',', $params['uids']);
            $conditions .= " AND uid IN ({$uids})";
        }
        if ($params['name']) {
            $conditions .= " AND name LIKE ?";
            $binds[] = "%{$params['name']}%";
        }
        $sql = "SELECT {$params['fields']} "
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY uid DESC";
        $items = array();
        $result = $this->db->fetchAll($sql, $binds);
        if ($result) {
            foreach ($result as & $v) {
                $items[$v->{$params['key']}] = & $v;
            }
        }
        return $items;
    }

}