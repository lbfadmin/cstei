<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Supervisor\Model;


use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 专家团队
 * Class SpotCheckModel
 * @package Module\Supervisor\Model
 */
class SpotCheckModel extends BaseModel
{

    protected $table = '{expert_team}';

    public static $fields = [
        'id',
        'department_name',		//团队名称
        'inspector',			//团队负责人
        'remark',				//团队介绍
        'qq',					//在线QQ
        'email',				//邮箱
        'time_checked'
    ];
/*
    public static $fields = [
        'id',
        'department_name',
        'product_batch_sn',
        'production_unit_id',
        'production_unit_name',
        'place',
        'type',
        'unqualified_type',
        'problem_chain',
        'status',
        'inspector',
        'remark',
        'progress',
        'time_checked'
    ];
*/

    public static $statuses = [
        'CREATED' => 1,
        'PENDING' => 2,
        'QUALIFIED' => 3,
        'UNQUALIFIED' => 4
    ];

    public static $unqualifiedTypes = [
        'MEDICINE_OVERPROOF' => 1,
        'BACTERIA_OVERPROOF' => 2,
        'SPOILED' => 3
    ];

    public static $progresses = [
        'PENDING' => 1,
        'PUNISHED' => 2
    ];

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

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => 'A.*',
            'order'  => 'A.id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $joins = '';
        if ($params['progress']) {
            $conditions .= ' AND progress = ?';
            $binds[] = $params['progress'];
        }
        if ($params['status']) {
            $conditions .= ' AND status = ?';
            $binds[] = $params['status'];
        }
        if ($params['production_unit_id']) {
            $joins .=
                ' LEFT JOIN {production_batch} AS B ' .
                ' ON A.product_batch_sn = B.sn';
            $conditions .= ' AND B.production_unit_id = ?';
            $binds[] = $params['production_unit_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} AS A"
            . $joins
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(A.id) AS count"
            . " FROM {$this->table} A"
            . $joins
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
        foreach ($list as &$item) {
            $item->status = array_search($item->status, self::$statuses);
        }
    }
}