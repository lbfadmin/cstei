<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 上午11:11
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;
use Module\Content\Model\GoodsModel;

/**
 * 入库记录
 * Class WarehousingModel
 * @package Module\Project\Model
 */
class WarehousingModel extends BaseModel
{
    protected $table = '{warehousing}';
    public static $fields = [
        'id', 'production_unit_id', 'warehouse_id',
        'goods_id', 'quantity',
        'packing', 'storage', 'temperature',
        'operator', 'time', 'batch_sn', 'time_created', 'time_updated'
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
        $goodsIds = [];
        foreach ($list as $item) {
            if ($item->goods_id) {
                $goodsIds[$item->goods_id] = $item->goods_id;
            }
        }
        if (!empty($goodsIds)) {
            $model = new GoodsModel();
            $goods = $model->getItems(['ids' => $goodsIds, 'fields' => 'id,name']);
            foreach ($list as &$item) {
                $item->goods_name = $goods[$item->goods_id]->name;
            }
        }
    }
}