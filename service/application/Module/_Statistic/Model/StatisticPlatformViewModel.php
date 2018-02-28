<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-4-17
 * Time: 下午3:21
 */

namespace Module\Statistic\Model;


use Application\Model\BaseModel;

/**
 * 平台企业统计
 * Class StatisticPlatformViewModel
 * @package Module\Statistic\Model
 */
class StatisticPlatformViewModel extends BaseModel
{

    protected $table = '{statistic_platform_view}';

    public static $fields = [
        'id',
        'date',
        'num_pv',
        'num_uv',
    ];

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'date DESC',
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
        return array(
            'list' => $result ?: array(),
        );
    }
}