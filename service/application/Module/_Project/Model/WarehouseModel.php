<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:00
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 仓库
 * Class WarehouseModel
 * @package Module\Project\Model
 */
class WarehouseModel extends BaseModel
{

    protected $table = '{warehouse}';

    public static $fields = [
        'id',
        'production_unit_id',
        'name',
        'operator',
        'ice_chest_sn',
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

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= " AND id = ?";
            $binds[] = $params['id'];
        }
        if ($params['name']) {
            $conditions .= " AND name LIKE ?";
            $binds[] = '%' . $params['name'] . '%';
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            'total' => $total
        );
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
        }
    }
}