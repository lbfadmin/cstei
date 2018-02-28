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
 * 平台企业统计ajax操作
 * Class PlatformCompany
 * @package Module\Statistic\Controller\Ajax
 */
class PlatformCompany extends Ajax
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
        $response = $this->api->call('statistic/platform-company/get-list', [
            'date_start' => date('Y-01-01'),
            'limit' => 12
        ]);
        $this->export($response);
    }
}