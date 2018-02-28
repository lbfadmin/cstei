<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/27
 * Time: 下午8:06
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 冷链车辆环境
 * Class LogisticsTruckEnvModel
 * @package Module\Project\Model
 */
class LogisticsTruckEnvModel extends BaseModel
{

    protected $table = '{logistics_truck_env}';
    public static $fields = [
        'id', 'truck_id', 'temperature', 'humidity', 'oxy',
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

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['truck_id']) {
            $conditions .= ' AND truck_id = ?';
            $binds[] = $params['truck_id'];
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
        $truckIds = [];
        foreach ($list as $item) {
            if ($item->truck_id)
                $truckIds[$item->truck_id] = $item->truck_id;
        }
        if (!empty($truckIds)) {
            $model = new LogisticsTruckModel();
            $lists = $model->getItems(['ids' => $truckIds]);
            foreach ($list as &$item) {
                $item->sn = $lists[$item->truck_id]->sn ?: '';
            }
        }
    }
}