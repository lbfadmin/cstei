<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 上午11:19
 */

namespace Module\Producer\Controller\Ajax\Farming;


use Module\Account\Controller\Ajax;

/**
 * 养殖环境管理ajax
 * Class Env
 * @package Module\Producer\Controller\Ajax\Farming
 */
class Env extends Ajax
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
     * 添加
     */
    public function create()
    {
        $data = $_GET;
        $data['production_unit_id'] = 1;
		if(array_key_exists("id", $data)) unset($data['id']);
		// print_r($data);
		// exit;
        $response = $this->api->call('project/production-env/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/production-env/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/production-env/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}