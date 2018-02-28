<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/28
 * Time: 下午10:02
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 渔药信息管理
 * Class Medicine
 * @package Module\Farming\Controller
 */
class Medicine extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_MEDICINE_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('producer/medicine/get-list');
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('farming/medicine/index');
    }
}