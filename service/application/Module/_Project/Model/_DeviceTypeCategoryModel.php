<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午5:33
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 设备类型分类
 * Class DeviceTypeCategoryModel
 * @package Module\Project\Model
 */
class DeviceTypeCategoryModel extends BaseModel
{
    protected $table = 'production_device_type_category';
    public static $fields = [
        'id', 'name', 'time_created'
    ];


    public function getList($params = array())
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
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
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'key' => 'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
        }
    }
}