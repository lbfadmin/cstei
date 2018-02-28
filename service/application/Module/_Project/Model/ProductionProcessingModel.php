<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 上午11:12
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 加工处理
 * Class ProductionProcessingModel
 * @package Module\Project\Model
 */
class ProductionProcessingModel extends BaseModel
{
    protected $table = '{production_processing}';
    public static $fields = [
        'id', 'production_unit_id', 'temp_pool_id', 'type', 'packing', 'checker',
        'weight', 'operator', 'time', 'batch_sn', 'time_created', 'time_updated'
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

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['batch_sn']) {
            $conditions .= ' AND batch_sn = ?';
            $binds[] = $params['batch_sn'];
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
        $poolIds = [];
        foreach ($list as &$item) {
            if ($item->temp_pool_id) {
                $poolIds[$item->temp_pool_id] = $item->temp_pool_id;
            }
        }
        if (!empty($poolIds)) {
            $model = new ProductionTempPoolModel();
            $pools = $model->getItems(['ids' => $poolIds]);
            foreach ($list as &$item) {
                $item->temp_pool_name = $pools[$item->temp_pool_id]->name ?: '';
            }
        }
    }
}