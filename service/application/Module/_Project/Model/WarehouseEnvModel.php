<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/27
 * Time: 下午9:04
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 仓库环境
 * Class WarehouseEnvModel
 * @package Module\Project\Model
 */
class WarehouseEnvModel extends BaseModel
{
    protected $table = '{warehouse_env}';
    public static $fields = [
        'id', 'warehouse_id', 'temperature', 'humidity', 'oxy',
        'time_created', 'time_updated'
    ];

    public function getItem($params = [])
    {
        $params = array_merge([
            'id' => null,
            'fields' => '*'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $item = $this->db->fetch($sql, $binds);
        $this->formatItems($item);
        return $item;
    }

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'key' => 'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['warehouse_id']) {
            $conditions .= ' AND warehouse_id = ?';
            $binds[] = $params['warehouse_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(1) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        $this->formatItems($result);
        return array(
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
        $Ids = [];
        foreach ($list as $item) {
            if ($item->warehouse_id)
                $Ids[$item->warehouse_id] = $item->warehouse_id;
        }
        if (!empty($Ids)) {
            $model = new WarehouseModel();
            $lists = $model->getItems(['ids' => $Ids]);
            foreach ($list as &$item) {
                $item->warehouse_name = $lists[$item->warehouse_id]->name ?: '';
            }
        }
    }
}