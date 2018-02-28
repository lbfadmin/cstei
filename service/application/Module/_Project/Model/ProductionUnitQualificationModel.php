<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Project\Model;


use Application\Component\View\AppView;
use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 企业资质
 * Class ProductionUnitQualificationModel
 * @package Module\Project\Model
 */
class ProductionUnitQualificationModel extends BaseModel
{

    protected $table = '{production_unit_qualification}';

    public static $fields = [
        'id',
        'production_unit_id',
        'name',
        'picture'
    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => 'A.*',
            'order'  => 'A.id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $joins = ' LEFT JOIN {production_unit} B ON A.production_unit_id = B.id';
        if ($params['production_unit_id']) {
            $conditions .= ' AND A.production_unit_id = ?';
            $binds[] = $params['production_unit_id'];
        }
        if ($params['production_unit_name']) {
            $conditions .= ' AND B.name LIKE ?';
            $binds[]= "%{$params['production_unit_name']}%";
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
            'list'  => $result ?: array(),
            'total' => $total
        );
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
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
        foreach ($list as &$item) {
            if (!empty($item->picture)) {
                $item->picture = AppView::img($item->picture);
            }
        }
    }
}