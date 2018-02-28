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
 * 加工记录管理
 * Class Processing
 * @package Module\Farming\Controller
 */
class Processing extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_PROCESSING_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-processing/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('farming/production-processing/index');
    }
}