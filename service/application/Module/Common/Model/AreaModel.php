<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-25
 * Time: 下午7:42
 */

namespace Module\Common\Model;


use Application\Model\BaseModel;

/**
 * 地区
 * Class AreaModel
 * @package Module\Common\Model
 */
class AreaModel extends BaseModel
{

    protected $table = '{common_area}';

    public static $fields = [
        'id',
        'parent_id',
        'name'
    ];

    public function getItem($params = []) 
    {
        $params = array_merge([
            'id' => null,
            'fields' => '*'
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['id']) {
            $conds .= ' AND id = ?';
            $binds[] = $params['id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        return $this->db->fetch($sql, $binds);
    }

    public function getItems($params = []) 
    {
        $params = array_merge([
            'ids' => null,
            'parent_id' => null,
            'fields' => '*',
            'key' => 'id'
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['ids']) {
            $ids = implode(',', $params['ids']);
            $conds .= " AND id IN({$ids})";
        }
        if ($params['parent_id']) {
            $conds .= " AND parent_id = ?";
            $binds[] = $params['parent_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }

    public function getAll($params = [])
    {
        $params = array_merge([
            'parent_id' => null,
            'fields' => '*',
            'name' => ''
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['parent_id'] !== null) {
            $conds .= ' AND parent_id = ?';
            $binds[] = $params['parent_id'];
        }
        if ($params['name'] !== null) {
            $conds .= ' AND name LIKE ?';
            $binds[] = "%{$params['name']}%";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        return $this->db->fetchAll($sql, $binds);
    }
}