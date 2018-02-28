<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-12-19
 * Time: 下午10:08
 */

namespace Module\Content\Model;


use Application\Model\BaseModel;

/**
 * 资讯分类
 * Class InfoCategoryModel
 * @package Module\Content\Model
 */
class InfoCategoryModel extends BaseModel
{

    public $table = '{content_info_category}';

    public static $fields = [
        'id',
        'parent_id',
        'name',
        'description',
        'weight',
    ];

    public function getItem($params = [])
    {
        $params = array_merge([
            'id' => null,
            'parent_id' => null,
            'fields' => '*'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }
        if ($params['parent_id']) {
            $conditions .= ' AND parent_id = ?';
            $binds[] = $params['parent_id'];
        }

        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetch($sql, $binds);
    }

    public function getAll($params = [])
    {
	
        $params = array_merge([
            'parent_id' => null,
            'fields' => '*'
        ], $params);			
	
        $conditions = '';
        $binds = [];
        if ($params['parent_id'] !== null) {
            $conditions .= ' AND parent_id = ?';
            $binds[] = $params['parent_id'];
        }

        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " ORDER BY `weight` ASC";
        return $this->db->fetchAll($sql, $binds);
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
        if ($params['parent_id'] !== null) {
            $conditions .= ' AND parent_id = '.$params['parent_id'];
            // $binds[] = ;
        }
	
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll($sql, [], null, $params['key']);
    }
}