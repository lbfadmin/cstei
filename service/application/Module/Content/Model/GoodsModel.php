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
 * 商品
 * Class GoodsModel
 * @package Module\Content\Model
 */
class GoodsModel extends BaseModel
{

    public $table = '{content_goods}';

    public static $fields = [
        'id',
        'category_id',
        'name',
        'picture',
        'description',
        'spec',
        'quantity',
        'price',
        'special_price',
        'time_created',
        'time_updated'
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

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $categoryIds = [];
        foreach ($list as &$item) {
            if (!empty($item->category_id)) {
                $categoryIds[$item->category_id] = $item->category_id;
            }
            if (!empty($item->picture)) {
                $item->picture = AppView::img($item->picture);
            }
        }
        if (!empty($categoryIds)) {
            $goodsCategoryModel = new GoodsCategoryModel();
            $categories = $goodsCategoryModel->getItems(['ids' => $categoryIds]);
            foreach ($list as &$item) {
                $item->category_name = isset($categories[$item->category_id])
                    ? $categories[$item->category_id]->name
                    : '';
            }
        }
    }
}