<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午4:33
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 养殖池分组管理
 * Class PoolCategory
 * @package Module\Farming\Controller\Ajax
 */
class PoolCategory extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_POOL_CATEGORY_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-pool-category/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/production-pool-category/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/production-pool-category/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}