<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/8
 * Time: 下午3:21
 */

namespace Module\Supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 生物多样性数据
 * Class Species
 * @package Module\Supervisor\Controller
 */
class Species extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_SPECIES_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('supervisor/biodiversity/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('supervisor/biodiversity/index');
    }

}