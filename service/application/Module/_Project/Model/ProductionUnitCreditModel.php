<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 上午11:10
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 企业诚信
 * Class ProductionUnitCreditModel
 * @package Module\Project\Model
 */
class ProductionUnitCreditModel extends BaseModel
{
    protected $table = '{production_unit_credit}';
    public static $fields = [
        'id', 'production_unit_id', 'rank', 'bad_management', 'supervisor_complaint',
        'production_unqualified', 'third_party_unqualified', 'time_created',
        'time_updated',
        'status'
    ];

    public static $statuses = [
        'OK' => 1,
        'IMPROVING' => 2,
    ];

    public function getItem($params = [])
    {
        $params = array_merge([
            'id' => null,
            'production_unit_id' => 0,
            'fields' => '*'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }
        if ($params['production_unit_id']) {
            $conditions .= ' AND production_unit_id = ?';
            $binds[] = $params['production_unit_id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $item = $this->db->fetch($sql, $binds);
        $this->formatItems($item);
        return $item;
    }

    public function getItems($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'production_unit_ids' => '',
            'key' => 'production_unit_id'
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
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => 'A.*',
            'order' => 'A.id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $joins = ' LEFT JOIN {production_unit} B ON A.production_unit_id = B.id';
        if ($params['status']) {
            $conditions .= ' AND A.status = ?';
            $binds[] = $params['status'];
        }
        if ($params['production_unit_id']) {
            $conditions .= ' AND A.production_unit_id = ?';
            $binds[] = $params['production_unit_id'];
        }
        if ($params['production_unit_name']) {
            $conditions .= ' AND B.name LIKE ?';
            $binds[] = "%{$params['production_unit_name']}%";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} A"
            . $joins
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(1) AS count"
            . " FROM {$this->table} A"
            . $joins
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
        $productionUnitIds = [];
        foreach ($list as &$item) {
            if ($item->production_unit_id) {
                $productionUnitIds[$item->production_unit_id] = $item->production_unit_id;
            }
        }
        if (!empty($productionUnitIds)) {
            $model = new ProductionUnitModel();
            $productionUnits = $model->getItems(['ids' => $productionUnitIds]);
            foreach ($list as &$item) {
                if (isset($productionUnits[$item->production_unit_id])) {
                    $item->production_unit_name = $productionUnits[$item->production_unit_id]->name;
                }
            }
        }
    }

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'production_unit_id' => '',
            'key' => 'id'
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
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }
}