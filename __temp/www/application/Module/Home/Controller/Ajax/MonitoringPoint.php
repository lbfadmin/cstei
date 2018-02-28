<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-14
 * Time: 下午3:57
 */

namespace Module\Home\Controller\Ajax;


use Application\Controller\Ajax;

/**
 * 监测点ajax
 * Class MonitoringPoint
 * @package Module\Home\Controller\Ajax
 */
class MonitoringPoint extends Ajax
{

    /**
     * 获取全部
     */
    public function getAll()
    {
        $response = $this->api->call('project/production-unit/get-all');
        $this->export($response);
    }
}