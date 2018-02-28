<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/27
 * Time: 下午10:52
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 饲料投放记录管理
 * Class FeedUse
 * @package Module\Farming\Controller
 */
class FeedUse extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_FEED_USE_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('producer/feed-use/get-list');
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
        $this->view->render('farming/feed-use/index');
    }
}