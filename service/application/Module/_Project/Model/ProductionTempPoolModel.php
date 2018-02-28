<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 上午11:11
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 暂养池
 * Class ProductionTempPoolModel
 * @package Module\Project\Model
 */
class ProductionTempPoolModel extends BaseModel
{
    protected $table = '{production_temp_pool}';
    public static $fields = [
        'id', 'production_unit_id', 'name', 'description', 'time_start',
        'time_end', 'status', 'product_type_id', 'time_created', 'time_updated'
    ];

    public static $statuses = [
        'FREE' => 0,
        'OK' => 1,
        'WARNING' => 2
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
        if ($params['id']) {
            $conditions .= " AND id = ?";
            $binds[] = $params['id'];
        }
        if ($params['product_type_id']) {
            $conditions .= " AND product_type_id = ?";
            $binds[] = $params['product_type_id'];
        }
        if ($params['status']) {
            $conditions .= " AND status = ?";
            $binds[] = $params['status'];
        }
        if ($params['name']) {
            $conditions .= " AND name LIKE ?";
            $binds[] = '%' . $params['name'] . '%';
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
        $productTypeIds = [];
        foreach ($list as $item) {
            if ($item->product_type_id) {
                $productTypeIds[$item->product_type_id] = $item->product_type_id;
            }
        }
        if (!empty($productTypeIds)) {
            $model = new ProductTypeModel();
            $types = $model->getItems(['ids' => $productTypeIds, 'fields' => 'id,name']);
            foreach ($list as &$item) {
                $item->product_type_name = $types[$item->product_type_id]->name;
            }
        }
    }
}