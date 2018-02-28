<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-4-17
 * Time: 下午3:21
 */

namespace Module\Statistic\Model;


use Application\Model\BaseModel;
use Module\Project\Model\ProductTypeModel;

/**
 * 平台养殖产量统计
 * Class StatisticPlatformOutputModel
 * @package Module\Statistic\Model
 */
class StatisticPlatformOutputModel extends BaseModel
{

    protected $table = '{statistic_platform_output}';

    public static $fields = [
        'id',
        'date',
        'product_type_id',
        'num_output',
    ];

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'date DESC,product_type_id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['date_start']) {
            $conditions .= ' AND date >= ?';
            $binds[] = $params['date_start'];
        }
        if ($params['date_end']) {
            $conditions .= ' AND date <= ?';
            $binds[] = $params['date_end'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $this->formatItems($result);
        return array(
            'list' => $result ?: array(),
        );
    }

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
        $productTypeIds = [];
        foreach ($list as $item) {
            if ($item->product_type_id)
                $productTypeIds[$item->product_type_id] = $item->product_type_id;
        }
        if (!empty($productTypeIds)) {
            $model = new ProductTypeModel();
            $types = $model->getItems(['ids' => $productTypeIds]);
            foreach ($list as &$item) {
                $item->product_type_name = $types[$item->product_type_id]->name ?: '';
            }
        }
    }
}