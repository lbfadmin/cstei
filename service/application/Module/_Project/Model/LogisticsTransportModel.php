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
 * 物流运输记录
 * Class LogisticsTransportModel
 * @package Module\Project\Model
 */
class LogisticsTransportModel extends BaseModel
{

    protected $table = '{logistics_transport}';

    public static $fields = [
        'id',
        'production_unit_id',
        'logistics_company_id',
        'truck_sn',
        'batch_sn',
        'env',
        'position',
        'time',
        'operator',
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

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $companyIds = [];
        foreach ($list as &$item) {
            if ($item->logistics_company_id) {
                $companyIds[$item->logistics_company_id] = $item->logistics_company_id;
            }
        }
        if (!empty($companyIds)) {
            $model = new LogisticsCompanyModel();
            $companies = $model->getItems(['ids' => $companyIds]);
            foreach ($list as &$item) {
                $item->logistics_company_name = $companies[$item->logistics_company_id]->name ?: '';
            }
        }
    }
}