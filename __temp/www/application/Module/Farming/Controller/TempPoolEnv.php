<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/27
 * Time: 下午9:28
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 暂养池环境记录管理
 * Class TempPoolEnv
 * @package Module\Farming\Controller
 */
class TempPoolEnv extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'farming/temp-pool/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_TEMP_POOL_ENV_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        //获取warehouse
        $response = $this->api->call('project/production-temp-pool/get-item', [
            'id' => $params['pool_id']
        ]);
        $item = $response->data->item;
        $this->view->pool = $item;
        $response = $this->api->call('project/production-temp-pool-env/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('farming/temppool-env/index');
    }
}