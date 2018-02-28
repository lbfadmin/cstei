<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午9:52
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 养殖环境
 * Class ProductionEnvModel
 * @package Module\Project\Model
 */
class ProductionYieldModel extends BaseModel
{
    protected $table = '{production_yield}';
    public static $fields = [
        'id', 'pool_id', 'amount', 'time_created', 'time_updated'
    ];

//    public static $fields = [
//        'id', 'pool_id', 'light', 'temperature', 'salt', 'an',
//        'ph', 'oxy', 'nn', 'time_created', 'time_updated'
//    ];	
	
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
        if ($params['pool_id']) {
            $conditions .= ' AND pool_id = ?';
            $binds[] = $params['pool_id'];
        }
        if ($params['created_start']) {
            $conditions .= ' AND time_created >= ?';
            $binds[] = $params['created_start'];
        }
        if ($params['created_end']) {
            $conditions .= ' AND time_created <= ?';
            $binds[] = $params['created_end'];
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

    public function getPoolsLatest($poolIds)
    {
        $sql = "SELECT A.* "
            . " FROM {$this->table} AS A"
            . " INNER JOIN ("
            . " SELECT pool_id, MAX(time_created) max_created "
            . " FROM production_env"
            . " WHERE pool_id IN({$poolIds}) "
            . " GROUP BY pool_id) AS B"
            . " WHERE A.pool_id = B.pool_id "
            . " AND A.time_created = B.max_created";
        return $this->db->fetchAll([
            'sql' => $sql,
            'key' => 'pool_id'
        ]);
    }

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
        $poolIds = [];
        foreach ($list as $item) {
            if ($item->pool_id)
                $poolIds[$item->pool_id] = $item->pool_id;
        }
        if (!empty($poolIds)) {
            $poolModel = new ProductTypeCategoryModel();//鱼的种类
            $pools = $poolModel->getItems(['ids' => $poolIds]);
            foreach ($list as &$item) {
                $item->pool_name = $pools[$item->pool_id]->name ?: '';
            }
        }
    }
}