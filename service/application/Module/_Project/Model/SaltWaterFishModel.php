<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Project\Model;


use Application\Component\View\AppView;
use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 养殖池
 * Class ProductionPoolModel
 * @package Module\Project\Model
 */
class SaltWaterFish extends BaseModel
{

    protected $table = '{saltwater_fish}';

    public static $fields = [
        'id',
        'name',
        'sort_num'
    ];

    public static $statuses = [
        'OK' => 1,
        'MAINTAIN' => 2,
        'WARNING' => 3
    ];

    public static  $exception_types = [
        // 'OXY' => 1, // 溶氧
        // 'TEMP' => 2, // 温度
        // 'FEED' => 3, // 饵料
    ];

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'key'   =>  'id'
        ], $params);
        $conditions = '';
        $binds = [];
        // if ($params['production_unit_id']) {
            // $conditions .= ' AND production_unit_id = ?';
            // $binds[]= $params['production_unit_id'];
        // }
        // if ($params['category_id'] != null) {
            // $conditions .= ' AND category_id = ?';
            // $binds[]= $params['category_id'];
        // }
        // if ($params['group_id'] != null) {
            // $conditions .= ' AND group_id = ?';
            // $binds[]= $params['group_id'];
        // }
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

    public function getItems($params = [])
    {
        $params = array_merge([
            'id' => null,
            'fields' => '*',
            'key' => 'idx'
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

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['category_id']) {
            $conditions .= " AND category_id = ?";
            $binds[] = $params['category_id'];
        }
        if ($params['group_id']) {
            $conditions .= " AND group_id = ?";
            $binds[] = $params['group_id'];
        }
        if ($params['id']) {
            $conditions .= " AND id = ?";
            $binds[] = $params['id'];
        }
        if ($params['product_type_id']) {
            $conditions .= " AND product_type_id = ?";
            $binds[] = $params['product_type_id'];
        }
        if ($params['status']) {
            $conditions .= " AND status = ?";
            $binds[] = $params['status'];
        }
        if ($params['name']) {
            $conditions .= " AND name LIKE ?";
            $binds[] = '%' . $params['name'] . '%';
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
        $productTypeIds = $categoryIds = $groupIds = [];
        foreach ($list as &$item) {
            if ($item->product_type_id) {
                $productTypeIds[$item->product_type_id] = $item->product_type_id;
            }
            if ($item->category_id) {
                $categoryIds[$item->category_id] = $item->category_id;
            }
            if ($item->group_id) {
                $groupIds[$item->group_id] = $item->group_id;
            }
        }
        if (!empty($productTypeIds)) {
            $productTypeModel = new ProductTypeModel();
            $types = $productTypeModel->getItems(['ids' => $productTypeIds]);
            foreach ($list as &$item) {
                $item->product_type_name = $types[$item->product_type_id]->name ?: '';
            }
        }
        if (!empty($groupIds)) {
            $groupModel = new ProductionPoolGroupModel();
            $groups = $groupModel->getItems(['ids' => $groupIds]);
            foreach ($list as &$item) {
                $item->group_name = $groups[$item->group_id]->name ?: '';
            }
        }
        if (!empty($categoryIds)) {
            $model = new ProductionPoolCategoryModel();
            $categories = $model->getItems(['ids' => $categoryIds]);
            foreach ($list as &$item) {
                $item->category_name = $categories[$item->category_id]->name ?: '';
            }
        }
    }
}