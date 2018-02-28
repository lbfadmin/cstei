<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午9:57
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 养殖环境
 * Class ProductionEnv
 * @package Module\Farming\Controller
 */
class ProductionEnv extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_ENV_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-env/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('farming/production-env/index');
    }

}