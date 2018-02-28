<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午1:07
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 循环水养殖-设备组
 * Class DeviceGroup
 * @package Module\Farming\Controller
 */
class DeviceGroup extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_DEVICE_GROUP_MANAGE'
        ];
    }


    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/device-group/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->activePath = 'farming/pool-group/index';
        $this->view->render('farming/device-group/index');
    }
}