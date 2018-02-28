<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 上午11:19
 */

namespace Module\Company\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 管理设备使用维护
 * Class Maintenance
 * @package Module\Company\Controller\Ajax\
 */
class DeviceUse extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_DEVICE_MAINTENANCE_MANAGE'
        ];
    }


    /**
     * 状态
     */
    public function usestatus()
    {
        $response = $this->api->call('producer/device-use/use-status', [
            'id' => $_REQUEST['id'],'status'=>$_REQUEST['status']
        ]);
        $this->export($response);
    }
}