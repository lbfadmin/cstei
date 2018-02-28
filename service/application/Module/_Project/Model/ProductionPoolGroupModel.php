<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午1:12
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 循环水养殖池组
 * Class ProductionPoolGroupModel
 * @package Module\Project\Model
 */
class ProductionPoolGroupModel extends BaseModel
{

    protected $table = '{production_pool_group}';

    public static $fields = [
        'id',
        'name',
        'description',
        'time_created',
        'time_updated',
    ];

    public function getItems($params = [])
    {
        $params = array_merge([
            'ids' => null,
            'fields' => '*',
            'key' => 'id'
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
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }
    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'name'   => '',
            'key'    =>  'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll([
            'sql'   =>  $sql,
            'binds' => $binds,
            'key'   => $params['key']
        ]);
    }


    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        return array(
            'list'  => $result ?: array(),
            'total' => $total
        );
    }
}