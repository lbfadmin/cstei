<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/27
 * Time: 下午8:39
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 暂养池环境
 * Class ProductionTempPoolEnvModel
 * @package Module\Project\Model
 */
class ProductionTempPoolEnvModel extends BaseModel
{
    protected $table = '{production_temp_pool_env}';
    public static $fields = [
        'id', 'pool_id', 'light', 'temperature', 'salt',
        'an', 'ph', 'oxy', 'nn',
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
        if ($params['pool_id']) {
            $conditions .= ' AND pool_id = ?';
            $binds[] = $params['pool_id'];
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
            if ($item->pool_id)
                $Ids[$item->pool_id] = $item->pool_id;
        }
        if (!empty($Ids)) {
            $model = new ProductionTempPoolModel();
            $pools = $model->getItems(['ids' => $Ids]);
            foreach ($list as &$item) {
                $item->pool_name = $pools[$item->pool_id]->name ?: '';
            }
        }
    }
}