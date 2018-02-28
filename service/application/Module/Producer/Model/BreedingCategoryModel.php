<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:12
 */

namespace Module\Producer\Model;


use Application\Model\BaseModel;

/**
 * 养殖鱼类
 * Class BreedingCategoryModel
 * @package Module\Producer\Model
 */
class BreedingCategoryModel extends BaseModel
{

    protected $table = '{breeding_category}';

    public static $fields = [
        'id',
        'name',
        'description',
        'weight',
        'parent_id'
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
        return $this->db->fetchAll([
            'sql'   =>  $sql,
            'binds' => $binds,
            'key'   => $params['key']
        ]);
    }

    public function getItems($params = [])
    {
        $params = array_merge([
            'ids' => null,
            'name'   => '',
            'fields' => '*',
            'key' => 'id'
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['ids']) {
            $ids = implode(',', $params['ids']);
            $conds .= " AND id IN({$ids})";
        }
		
        if ($params['name']) {
            // $ids = implode(',', $params['ids']);
			$name = $params['name'];
            $conds .= " AND name ='{$name}'";
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
}