<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 上午11:19
 */

namespace Module\Producer\Controller\Ajax\Breeding;


use Module\Account\Controller\Ajax;

/**
 * 管理设备开关机记录ajax
 * Class Power
 * @package Module\Producer\Controller\Ajax\Device
 */
class BreedingArea extends Ajax
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
     * 添加
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = 1;
        $response = $this->api->call('project/device-power/create', $data);
        $this->export($response);
    }
     */


    /**
     * 更新
     */
/*
    public function update()
    {
        $response = $this->api->call('project/device-power/update', $_POST);
        $this->export($response);
    }
*/

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('producer/breeding-area/delete', [
            'id' => $_REQUEST['id']
        ]);
		
        $this->export($response);
    }
}