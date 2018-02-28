<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午6:24
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 设备维护记录
 * Class DeviceMaintenanceModel
 * @package Module\Project\Model
 */
class DeviceMaintenanceModel extends BaseModel
{

    protected $table = 'production_device_maintenance';
    public static $fields = [
        'id', 'device_sn', 'type', 'description', 'time_maintained',
        'time_created'
    ];

    public function getList($params = array())
    {
        $params = array_merge(array(
            'fields' => '*',
            'device_sn' => '',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['device_sn']) {
            $conditions .= " AND device_sn = ?";
            $binds[] = $params['device_sn'];
        }
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
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
        }
    }

}