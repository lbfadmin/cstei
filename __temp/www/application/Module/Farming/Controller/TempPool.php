<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/2
 * Time: 下午2:28
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 暂养池管理
 * Class TempPool
 * @package Module\Farming\Controller
 */
class TempPool extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_TEMP_POOL_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-temp-pool/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        //获取产品类型
        $response = $this->api->call('project/product-type/get-all');
        $this->view->product_types = $response->data->list;
        $this->view->render('farming/production-temp-pool/index');
    }
}