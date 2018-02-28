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
 * Class StatisticPlatformCompanyModel
 * @package Module\Statistic\Model
 */
class StatisticPlatformCompanyModel extends BaseModel
{

    protected $table = '{statistic_platform_company}';

    public static $fields = [
        'id',
        'category',
        'num',
        'date',
        'add_time'
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


	/*取得最近的产量记录*/
    public function getListLatest($params = [])
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'date DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];

        $sql = "SELECT t1.*"
            . " FROM {$this->table} t1, "
			." (select date from {$this->table} order by date desc limit 0, 1) t2"
            . " WHERE t1.date = t2.date {$conditions}"
            . " ORDER BY {$params['order']}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        return array(
            'list' => $result ?: array(),
        );
    }
}