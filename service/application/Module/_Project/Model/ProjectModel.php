<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 上午11:57
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 项目
 * Class ProjectModel
 * @package Module\Project\Model
 */
class ProjectModel extends BaseModel
{

    protected $table = '{project}';

    public static $fields = [];

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

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
    }
}