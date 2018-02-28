<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-4-17
 * Time: 下午3:15
 */

namespace Module\Statistic\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 平台访问统计ajax操作
 * Class PlatformView
 * @package Module\Statistic\Controller\Ajax
 */
class PlatformView extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    protected function permission()
    {
        return [
            '__ALL__' => 'VIEW_PLATFORM_STATISTIC'
        ];
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $response = $this->api->call('statistic/platform-view/get-list', [
            'date_start' => date('Y-m-01', strtotime('-1 month')),
            'limit' => 31
        ]);
        $this->export($response);
    }
}