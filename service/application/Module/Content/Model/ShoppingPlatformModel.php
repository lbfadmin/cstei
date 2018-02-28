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
 * 购物平台
 * Class ShoppingPlatformModel
 * @package Module\Content\Model
 */
class ShoppingPlatformModel extends BaseModel
{

    public $table = '{shopping_platform}';

    public static $fields = [
        'id',
        'name',
        'picture',
        'description',
        'url',
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

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll($sql, $binds);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
            if (!empty($item->picture)) {
                $item->picture = AppView::img($item->picture);
            }
        }
    }
}