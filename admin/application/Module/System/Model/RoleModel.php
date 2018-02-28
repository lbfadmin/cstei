<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

/**
 * 角色
 * Class RoleModel
 * @package Module\System\Model
 */
class RoleModel extends BaseModel
{

    protected $table = '{role}';

    public static $fields = [
        'id',
        'parentId',
        'name',
        'description',
        'timeCreated',
    ];

    public function getItem($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'id' => 0,
            'name' => ''
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['id']) {
            $conds .= " AND id = ?";
            $binds[] = $params['id'];
        }
        if ($params['name']) {
            $conds .= " AND name = ?";
            $binds[] = $params['name'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}"
            . " LIMIT 1";
        return $this->db->fetch($sql, $binds);
    }

    public function getItems($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'ids' => [],
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['ids']) {
            $ids = implode(',', $params['ids']);
            $conds .= " AND id IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        return $this->db->fetchAll($sql, $binds);
    }

    /**
     * 获取所有
     *
     * @param string $fields 获取的字段
     * @return array 结果集
     */
    public function getAll($fields = '*')
    {
        $sql = "SELECT {$fields} "
            . " FROM {$this->table} "
            . " ORDER BY id DESC";
        $items = array();
        $result = $this->db->fetchAll($sql);
        if ($result) {
            foreach ($result as & $v) {
                $items[$v->id] = $v;
            }
        }
        return $items;
    }

}