<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/5
 * Time: 下午8:47
 */

namespace Module\Supervisor\Model;


use Application\Model\BaseModel;

/**
 * 水质监测
 * Class WaterQualityModel
 * @package Module\Supervisor\Model
 */
class WaterQualityModel extends BaseModel
{
    protected $table = '{supervision_water_quality}';

    public static $fields = [
        'id', 'monitoring_point_id', 'an_yan', 'gui_suan_yan', 'ya_xiao_suan_yan', 'lin_suan_yan',
        'ye_lv_su', 'xiao_suan_yan', 'rong_jie_xing_you_ji_tan',
        'rong_jie_xing_you_ji_dan', 'ke_li_xing_you_ji_tan', 'ke_li_xing_you_ji_dan',
        'shui_wen', 'ph', 'rong_yang',
        'time', 'device_id', 'time_created', 'time_updated'
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
            'order' => 'time DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['monitoring_point_id']) {
            $conditions .= ' AND monitoring_point_id = ?';
            $binds[] = $params['monitoring_point_id'];
        }
        if ($params['time_start']) {
            $conditions .= ' AND time >= ?';
            $binds[] = $params['time_start'];
        }
        if ($params['time_end']) {
            $conditions .= ' AND time <= ?';
            $binds[] = $params['time_end'];
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
        $pointIds = [];
        foreach ($list as $item) {
            if ($item->monitoring_point_id)
                $pointIds[$item->monitoring_point_id] = $item->monitoring_point_id;
        }
        if (!empty($pointIds)) {
            $model = new MonitoringPointModel();
            $points = $model->getItems(['ids' => $pointIds]);
            foreach ($list as &$item) {
                $item->monitoring_point_name = $points[$item->monitoring_point_id]->name ?: '';
            }
        }
    }
}