<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午9:57
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 养殖环境
 * Class ProductionEnv
 * @package Module\Farming\Controller\Ajax
 */
class ProductionEnv extends Ajax
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
     * 获取列表
     */
    public function getList()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-env/get-list', $params);
        $this->export($response);
    }

    /**
     * 获取全部
     */
    public function getAll()
    {
        $params = $this->input->getArray();
        $params['limit'] = 10000;
        $response = $this->api->call('project/production-env/get-list', $params);
        $this->export($response);
    }
}