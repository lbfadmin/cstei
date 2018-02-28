<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午4:33
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 设备ajax操作
 * Class Device
 * @package Module\Farming\Controller\Ajax
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
            '__ALL__' => 'FARMING_DEVICE_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/device/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/device/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/device/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }

    /**
     * 开机
     */
    public function powerOn()
    {
        $response = $this->api->call('project/device/power-on', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }

    /**
     * 关机
     */
    public function powerOff()
    {
        $response = $this->api->call('project/device/power-off', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}