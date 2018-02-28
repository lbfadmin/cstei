<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午2:36
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 循环水养殖-设备组
 * Class DeviceGroupModel
 * @package Module\Project\Model
 */
class DeviceGroupModel extends BaseModel
{

    protected $table = '{production_device_group}';

    public static $fields = [
        'id',
        'name',
        'pool_group_id'
    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['pool_group_id']) {
            $conditions .= " AND pool_group_id = ?";
            $binds[] = $params['pool_group_id'];
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

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'production_unit_id' => 0,
            'category_id' => 0,
            'name' => '',
            'key'   =>  'id'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['pool_group_id']) {
            $conditions .= ' AND pool_group_id = ?';
            $binds[]= $params['pool_group_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll([
            'sql' => $sql,
            'binds' =>  $binds,
            'key'   =>  $params['key']
        ]);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $groupIds = [];
        foreach ($list as &$item) {
            if ($item->pool_group_id) {
                $groupIds[$item->pool_group_id] = $item->pool_group_id;
            }
        }
        if (!empty($groupIds)) {
            $groupModel = new ProductionPoolGroupModel();
            $groups = $groupModel->getItems(['ids' => $groupIds]);
            foreach ($list as &$item) {
                $item->pool_group_name = $groups[$item->pool_group_id]->name ?: '';
            }
        }
    }
}