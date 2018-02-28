<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:00
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 产品抽检
 * Class SpotCheckModel
 * @package Module\Project\Model
 */
class SpotCheckModel extends BaseModel
{

    protected $table = '{production_spot_check}';

    public static $fields = [
        'id',
        'production_unit_id',
        'batch_sn',
        'sampling',
        'operator',
        'position',
        'results',
        'status',
        'time_taken'
    ];

    public static $statuses = [

    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
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

    public function getItems($params = []) {
        $params = array_merge([
            'fields' => '*',
            'name'   => '',
            'production_unit_ids' => '',
            'key'    =>  'production_unit_id'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['production_unit_ids']) {
            $unitIds = implode(',', $params['production_unit_ids']);
            $conditions .= " AND production_unit_id IN ({$unitIds})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll([
            'sql'   =>  $sql,
            'binds' => $binds,
            'key'   => $params['key']
        ]);
    }



    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
        }
    }
}