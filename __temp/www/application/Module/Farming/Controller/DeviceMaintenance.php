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
 * 设备维护记录
 * Class DeviceMaintenance
 * @package Module\Farming\Controller
 */
class DeviceMaintenance extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_DEVICE_MAINTENANCE_MANAGE'
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
        $response = $this->api->call('project/device-maintenance/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->types = [
            1 => '正常',
            2 => '异常'
        ];
        $this->view->activePath = 'farming/device/index';
        $this->view->render('farming/device-maintenance/index');
    }
}