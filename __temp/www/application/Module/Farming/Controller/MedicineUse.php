<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/28
 * Time: 下午10:21
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 渔药投放记录管理
 * Class MedicineUse
 * @package Module\Farming\Controller
 */
class MedicineUse extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_MEDICINE_USE_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('producer/medicine-use/get-list');
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        //获取饲料
        $response = $this->api->call('producer/feed//get-all');
        $this->view->feeds = $response->data->list;
        //获取养殖池
        $response = $this->api->call('project/production-pool/get-all');
        $this->view->pools = $response->data->list;
        $this->view->render('farming/medicine-use/index');
    }
}