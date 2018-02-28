<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 上午11:44
 */

namespace Module\Project\Controller;


use Module\Account\Controller\Auth;

/**
 * 管理产品类型分类
 * Class ProductTypeCategory
 * @package Module\Project\Controller
 */
class ProductTypeCategory extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $response = $this->api->call('project/product-type-category/get-all', $params);
        $this->view->list = $response->data->list;
        $this->view->render('project/product-type-category/index');
    }

}