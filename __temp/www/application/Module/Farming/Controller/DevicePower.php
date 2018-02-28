<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 设备开关机记录
 * Class DevicePower
 * @package Module\Farming\Controller
 */
class DevicePower extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_DEVICE_POWER_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        //获取设备
        $params['limit'] = 20;
        $response = $this->api->call('project/device-power/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->operations = [
            1 => '开机',
            2 => '关机'
        ];
        $this->view->activePath = 'farming/device/index';
        $this->view->render('farming/device-power/index');
    }
}