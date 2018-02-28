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
 * 批次
 * Class BatchModel
 * @package Module\Project\Model
 */
class BatchModel extends BaseModel
{

    protected $table = '{production_batch}';

    public static $fields = [
        'id',
        'production_unit_id',
        'product_type_id',
        'sn',
        'amount',
        'expect_amount',
        'expect_weight',
        'date_start',
        'date_end',
        'description'
    ];

    public static $statuses = [];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['product_type_id']) {
            $conditions .= " AND product_type_id = ?";
            $binds[] = $params['product_type_id'];
        }
        if ($params['sn']) {
            $conditions .= " AND sn LIKE ?";
            $binds[] = '%' . $params['sn'] . '%';
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

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $productionUnitIds = $productTypeIds = $sns = [];

        foreach ($list as &$item) {
            if ($item->production_unit_id) {
                $productionUnitIds[$item->production_unit_id] = $item->production_unit_id;
            }
            if ($item->product_type_id) {
                $productTypeIds[$item->product_type_id] = $item->product_type_id;
            }
            $sns[$item->sn] = $item->sn;
        }
        $batchPoolModel = new BatchPoolModel();
        $batchPools = $batchPoolModel->getItemsBySns($sns);
        foreach ($list as &$item) {
            $item->pools = $batchPools[$item->sn];
        }
        if (!empty($productTypeIds)) {
            $productTypeModel = new ProductTypeModel();
            $types = $productTypeModel->getItems(['ids' => $productTypeIds]);
            foreach ($list as &$item) {
                $item->product_type_name = $types[$item->product_type_id]->name ?: '';
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
}