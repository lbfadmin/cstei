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
 * 管理设备开关机记录ajax
 * Class Power
 * @package Module\Company\Controller\Ajax\Device
 */
class Device extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_DEVICE_POWER_MANAGE'
        ];
    }


    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('producer/device/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
    /**
     * 启用
     */
    public function start()
    {
        $response = $this->api->call('producer/device/start', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
    /**
     * 停用
     */
    public function stop()
    {
        $response = $this->api->call('producer/device/stop', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}