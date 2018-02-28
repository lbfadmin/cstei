<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:00
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;


/**
 * 设备
 * Class DeviceModel
 * @package Module\Project\Model
 */
class DeviceModel extends BaseModel
{

    protected $table = '{production_device}';

    public static $fields = [
        'id',
        'production_unit_id',
        'sn',
        'type_id',
        'container_type',
        'container_id',
        'group_id',
        'time_purchased',
        'time_created',
        'time_updated',
        'status',
        'description'
    ];

    /**
     * 上级容器类型
     * @var array
     */
    public static $containerTypes = [
        'POOL' => 1, // 养殖池
        'DEVICE_GROUP' => 2 // 设备组
    ];

    /**
     * 状态
     * @var array
     */
    public static $statuses = [
        'RUNNING' => 1, // 运行中
        'MAINTAIN' => 2, // 检查维修
        'STOPPED' => 3, // 停止
        'DOWN' => 4, // 故障
    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'container_type' => 0,
            'container_id' => 0,
            'status' => 0,
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['container_type']) {
            $conditions .= " AND container_type = ?";
            $binds[] = $params['container_type'];
        }
        if ($params['container_id']) {
            $conditions .= " AND container_id = ?";
            $binds[] = $params['container_id'];
        }
        if ($params['status']) {
            $conditions .= " AND status = ?";
            $binds[] = $params['status'];
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
            'list'  => $result ?: array(),
            'total' => $total
        );
    }

    /**
     * 容器获取设备
     * @param int $containerType
     * @param array $containerIds
     * @return array
     */
    public function getAllByContainer(int $containerType, array $containerIds)
    {
        $ids = implode(',', $containerIds);
        $sql = "SELECT * "
            . " FROM {$this->table}"
            . " WHERE container_type = ?"
            . " AND container_id IN({$ids})";
        $items = $this->db->fetchAll($sql, [$containerType]);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
            if (isset($item->status)) {
                $item->status = array_search($item->status, self::$statuses);
            }
            if (isset($item->container_type)) {
                $item->container_type = array_search($item->container_type, self::$containerTypes);
            }
        }
    }
}