<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:12
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 产品类型
 * Class ProductTypeModel
 * @package Module\Project\Model
 */
class ProductTypeModel extends BaseModel
{

    protected $table = '{product_type}';

    public static $fields = [
        'id',
        'category_id',
        'name',
        'description'
    ];

    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*',
            'name'   => '',
            'key'    =>  'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $result = $this->db->fetchAll([
            'sql'   =>  $sql,
            'binds' => $binds,
            'key'   => $params['key']
        ]);
        $this->formatItems($result);
        return $result;
    }

    public function getItems($params = [])
    {
        $params = array_merge([
            'ids' => null,
            'fields' => '*',
            'key' => 'id'
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

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
        $categoryIds = [];
        foreach ($list as $item) {
            if ($item->category_id)
                $categoryIds[$item->category_id] = $item->category_id;
        }
        if (!empty($categoryIds)) {
            $model = new ProductTypeCategoryModel();
            $categories = $model->getItems(['ids' => $categoryIds]);
            foreach ($list as &$item) {
                $item->category_name = $categories[$item->category_id]->name ?: '';
            }
        }
    }
}