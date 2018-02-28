<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-2-3
 * Time: 下午2:27
 */

namespace Module\Farming\Controller;


use Module\Account\Controller\Auth;

/**
 * 养殖池分组管理
 * Class PoolCategory
 * @package Module\Farming\Controller
 */
class PoolCategory extends Auth
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
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $response = $this->api->call('project/production-pool-category/get-tree', $params);
        $this->view->categories = $response->data->children;
        $this->view->render('farming/pool/category');
    }
}