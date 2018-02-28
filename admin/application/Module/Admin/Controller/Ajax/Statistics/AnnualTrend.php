<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/6
 * Time: 下午10:52
 */

namespace Module\Producer\Controller\Ajax\Statistics;


use Module\Account\Controller\Ajax;

/**
 * 管理企业年度营收趋势ajax
 * Class AnnualTrend
 * @package Module\Producer\Controller\Ajax\Statistics
 */
class AnnualTrend extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STATISTICS_ANNUAL_TREND'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerAnnualTrend/delete', $data);
        $this->export($response);
    }
}