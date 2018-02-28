<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-10-17
 * Time: 下午8:24
 */

namespace Module\Content\Model;


use Application\Component\View\AppView;
use Application\Model\BaseModel;

/**
 * 商品订单
 * Class PurchaseModel
 * @package Module\Content\Model
 */
class PurchaseModel extends BaseModel
{

    public $table = '{goods_purchase}';

    public static $fields = [
        'id',
        'goods_id',
        'batch_sn',
        'sn',
        'type',
        'channel',
        'platform_id',
        'quantity',
        'unit_price',
        'total_price',
        'customer_name',
        'customer_address',
        'customer_contact',
        'customer_tel',
        'pay_type',
        'time_paid',
        'time_sent',
        'logistics_info',
        'rank',
        'remark',
        'time_created',
        'time_updated',
        'time_purchased',
        'time_evaluated',
    ];

    /**
     * 获取一个
     * @param array $params
     * @return mixed
     */
    public function getItem($params = array())
    {
        $params = array_merge(array(
            'id' => 0,
            'fields' => '*'
        ), $params);
        $conditions = '';
        $binds = array();
        if ($params['id']) {
            $conditions .= " AND id = ?";
            $binds[] = $params['id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " LIMIT 1";
        $item = $this->db->fetch($sql, $binds);
        $this->formatItems($item);
        return $item;
    }

    public function getItems($params = array())
    {
        $params = array_merge(array(
            'fields' => '*',
            'ids' => [],
            'key' => 'id'
        ), $params);
        $conditions = '';
        if (!empty($params['ids'])) {
            $ids = implode(',', $params['ids']);
            $conditions .= " AND id IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll($sql, [], null, $params['key']);
        $this->formatItems($items);
        return $items;
    }

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['goods_id']) {
            $conditions .= " AND goods_id = ?";
            $binds[] = $params['goods_id'];
        }
        if ($params['sn']) {
            $conditions .= " AND sn = ?";
            $binds[] = $params['sn'];
        }
        if ($params['batch_sn']) {
            $conditions .= " AND batch_sn = ?";
            $binds[] = $params['batch_sn'];
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

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $goodsIds = [];
        foreach ($list as &$item) {
            if (!empty($item->picture)) {
                $item->picture = AppView::img($item->picture);
            }
            if (!empty($item->goods_id)) {
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