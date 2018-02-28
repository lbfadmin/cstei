<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 上午11:44
 */

namespace Module\Consumer\Controller\Goods;


use Module\Account\Controller\Auth;

/**
 * 商品类目
 * Class Category
 * @package Module\Consumer\Controller\Goods
 */
class Category extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_GOODS_CATEGORY_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $response = $this->api->call('content/goods-category/get-tree', $params);
        $this->view->categories = $response->data->children;
        $this->view->render('consumer/goods/category/index');
    }

}