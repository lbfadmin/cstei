<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午9:19
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 企业行情预估
 * Class ProducerMarketModel
 * @package Module\Project\Model
 */
class ProducerMarketModel extends BaseModel
{
    protected $table = '{statistic_producer_market}';

    public static $fields = [
        'id', 'production_unit_id', 'date', 'production', 'unit_price'
    ];

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

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'key' => 'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(1) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        $this->formatItems($result);
        return array(
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
    }
}