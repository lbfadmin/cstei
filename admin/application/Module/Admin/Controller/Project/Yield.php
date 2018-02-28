<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\Farming;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 养殖视频管理
 * Class Video
 * @package Module\Producer\Controller\Farming
 */
class Video extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_FARMING_VIDEO_MANAGE'
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
        $response = $this->api->call('project/production-video/get-list', $params);
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
        //获取养殖池
        $response = $this->api->call('project/production-pool/get-all');
        $this->view->pools = $response->data->list;
        $this->view->render('producer/farming/video/index');
    }
}