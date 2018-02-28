<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-22
 * Time: 下午4:21
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 养殖设备管理
 * Class Device
 * @package Module\Farming\Controller
 */
class Device extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'farming/device/index';
    }

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
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/device/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        //获取设备类型
        $response = $this->api->call('project/device-type/get-all');
        $this->view->types = $response->data->list;
        $this->view->render('farming/device/index');
    }
}