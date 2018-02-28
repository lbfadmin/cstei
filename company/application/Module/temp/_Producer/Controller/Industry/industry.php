<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\Industry;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 产业动态
 * Class Env
 * @package Module\Producer\Controller\Farming
 */
class Industry extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_FARMING_ENV_MANAGE'
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
        $response = $this->api->call('project/industry/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->operations = [
            1 => '正常',
            2 => '异常'
        ];
		
		$response = $this->api->call('project/product-type-category/get-all');
        $this->view->categories = $response->data->list;
        $this->view->render('producer/industry/industry/index');
    }
}