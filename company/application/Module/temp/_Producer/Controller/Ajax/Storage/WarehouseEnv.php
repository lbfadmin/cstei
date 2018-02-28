<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 上午11:19
 */

namespace Module\Producer\Controller\Ajax\Storage;


use Module\Account\Controller\Ajax;

/**
 * 仓储环境管理
 * Class WarehouseEnv
 * @package Module\Producer\Controller\Ajax\Storage
 */
class WarehouseEnv extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STORAGE_WAREHOUSE_ENV_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = 1;
        $response = $this->api->call('project/warehouse-env/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/warehouse-env/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/warehouse-env/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}