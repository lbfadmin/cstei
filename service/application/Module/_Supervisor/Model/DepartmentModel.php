<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Supervisor\Model;


use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 部门
 * Class DepartmentModel
 * @package Module\Supervisor\Model
 */
class DepartmentModel extends BaseModel
{

    protected $table = '{supervision_department}';

    public static $fields = [
        'id',
        'name',
        'description',
        'province_id',
        'city_id',
        'district_id',
        'block_id',
        'community_id',
    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
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
            if ($item->block_id) {
                $areaIds[$item->block_id] = $item->block_id;
            }
            if ($item->community_id) {
                $areaIds[$item->community_id] = $item->community_id;
            }
        }
        if (!empty($areaIds)) {
            $areaModel = new AreaModel();
            $areas = $areaModel->getItems(['ids' => $areaIds]);
            foreach ($list as &$item) {
                $item->province_name = $areas[$item->province_id]->name ?: '';
                $item->city_name = $areas[$item->city_id]->name ?: '';
                $item->district_name = $areas[$item->district_id]->name ?: '';
                $item->block_name = $areas[$item->block_id]->name ?: '';
                $item->community_name = $areas[$item->community_name]->name ?: '';
            }
        }
    }
}