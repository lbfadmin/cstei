<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午9:15
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 企业渠道比重
 * Class ProducerChannelWeightModel
 * @package Module\Project\Model
 */
class ProducerChannelWeightModel extends BaseModel
{
    protected $table = '{statistic_producer_channel_weight}';

    public static $fields = [
        'id', 'production_unit_id', 'parent_id', 'name', 'weight'
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
        $items = $this->db->fetchAll($sql, $binds);
        $this->formatItems($items);
        return $items;
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
}