<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-28
 * Time: 下午3:22
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 生产抽检管理
 * Class Check
 * @package Module\Farming\Controller
 */
class Check extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_CHECK_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/spot-check/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->statuses = [
            '1' => '合格',
            '2' => '不合格',
        ];
        $this->view->render('farming/check/index');
    }
}