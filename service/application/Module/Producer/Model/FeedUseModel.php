<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:22
 */

namespace Module\Producer\Model;


use Application\Model\BaseModel;
use Module\Project\Model\ProductionPoolModel;

/**
 * 饲料投放
 * Class FeedUseModel
 * @package Module\Producer\Model
 */
class FeedUseModel extends BaseModel
{
    protected $table = '{feed_use}';
    public static $fields = [
        'id', 'type', 'time_fed', 'amount', 'position',
        'pool_id', 'batch_sn', 'batch_id'
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

    public function getNewestItem($params = [])
    {
        $params = array_merge([
            'id' => null,
            'batch_sn' => '',
            'batch_sns' => null,
            'fields' => '*'
        ], $params);
        $conditions = $join = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }

        if ($params['batch_sns']) {
            $batchIds = implode("','", $params['batch_sns']);
            $conditions .= " AND batch_sn IN('{$batchIds}')";
        }

        $sql = "SELECT MAX(time_fed) as time_fed,batch_sn"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " GROUP BY batch_sn"
            . " ORDER BY time_fed DESC";
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => 'batch_sn'
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
        $feedIds = $poolIds = [];
        foreach ($list as $item) {
            if ($item->type)
                $feedIds[$item->type] = $item->type;
            if ($item->pool_id)
                $poolIds[$item->pool_id] = $item->pool_id;
        }
        if (!empty($feedIds)) {
            $model = new FeedModel();
            $feeds = $model->getItems(['ids' => $feedIds]);
            foreach ($list as &$item) {
                $item->type_name = $feeds[$item->type]->name ?: '';
            }
        }
        if (!empty($poolIds)) {
            $model = new ProductionPoolModel();
            $pools = $model->getItems(['ids' => $poolIds]);
            foreach ($list as &$item) {
                $item->pool_name = $pools[$item->pool_id]->name ?: '';
            }
        }
    }

}