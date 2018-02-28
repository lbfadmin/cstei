<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午5:31
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 设备类型管理
 * Class DeviceType
 * @package Module\Farming\Controller
 */
class DeviceType extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_DEVICE_TYPE_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/device-type/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $response = $this->api->call('project/device-type-category/get-all');
        $this->view->categorys = $response->data->list;
        $this->view->render('farming/device-type/index');
    }

}