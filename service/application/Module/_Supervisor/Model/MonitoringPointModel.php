<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-2
 * Time: 下午1:52
 */

namespace Module\Supervisor\Model;


use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 监测点
 * Class MonitoringPointModel
 * @package Module\Supervisor\Model
 */
class MonitoringPointModel extends BaseModel
{

    protected $table = '{supervision_monitoring_point}';

    public static $fields = [
        'id',
        'name',
        'province_id',
        'city_id',
        'district_id',
        'lon',
        'lat',
        'time_created'
    ];

    public function getItem($params = []) {
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

    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'name'   => '',
            'key'    =>  null
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['province_id']) {
            $conditions .= ' AND province_id = ?';
            $binds[] = $params['province_id'];
        }
        if ($params['city_id']) {
            $conditions .= ' AND city_id = ?';
            $binds[] = $params['city_id'];
        }
        if ($params['district_id']) {
            $conditions .= ' AND district_id = ?';
            $binds[] = $params['district_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll([
            'sql'   =>  $sql,
            'binds' => $binds,
            'key'   => $params['key']
        ]);
        $this->formatItems($items);
        return $items;
    }

    private function formatItems(&$items) {
        $list = is_array($items) ? $items : [$items];
        $areaIds = [];
        foreach ($list as &$item) {
            if ($item->province_id) {
                $areaIds[$item->province_id] = $item->province_id;
            }
            if ($item->city_id) {
                $areaIds[$item->city_id] = $item->city_id;
            }
            if ($item->district_id) {
                $areaIds[$item->district_id] = $item->district_id;
            }
        }
        if (!empty($areaIds)) {
            $areaModel = new AreaModel();
            $areas = $areaModel->getItems(['ids' => $areaIds]);
            foreach ($list as &$item) {
                $item->province_name = $areas[$item->province_id]->name ?: '';
                $item->city_name = $areas[$item->city_id]->name ?: '';
                $item->district_name = $areas[$item->district_id]->name ?: '';
            }
        }
    }
}