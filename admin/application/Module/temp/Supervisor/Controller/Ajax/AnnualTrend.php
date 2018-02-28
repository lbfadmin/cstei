<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/6
 * Time: 下午10:52
 */

namespace Module\Supervisor\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 行业年度营收趋势ajax
 * Class AnnualTrend
 * @package Module\Supervisor\Controller\Ajax
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
            '__ALL__' => 'SUPERVISOR_ANNUAL_TREND_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/SupervisorAnnualTrend/delete', $data);
        $this->export($response);
    }
}