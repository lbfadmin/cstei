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
 * 平台财务统计
 * Class StatisticPlatformFinanceModel
 * @package Module\Statistic\Model
 */
class StatisticPlatformFinanceModel extends BaseModel
{

    protected $table = '{production_yield}';

    public static $fields = [
        'id',
        'pool_id',
		'DATE_FORMAT(time_created, "%Y年%m月") data',
        'amount',
        'time_created',
        'time_updated',
    ];

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => 'pool_id,DATE_FORMAT(time_created, "%Y年%m月") date, avg(amount) as amount',
            'order' => 'time_created DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['pool_id']) {
            $conditions .= ' AND pool_id = ?';
            $binds[] = $params['pool_id'];
        }
/*
        if ($params['date_end']) {
            $conditions .= ' AND date <= ?';
            $binds[] = $params['date_end'];
        }
*/
        $sql = "SELECT pool_id,DATE_FORMAT(time_created, '%Y年%m月') date, avg(amount) as amount"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " GROUP BY pool_id,DATE_FORMAT(time_created, '%Y年%m月')"
            . " ORDER BY pool_id,DATE_FORMAT(time_created, '%Y年%m月') desc";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        return array(
            'list' => $result ?: array(),
        );
    }
}