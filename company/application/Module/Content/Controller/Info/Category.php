<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 上午11:44
 */

namespace Module\Content\Controller\Info;


use Module\Account\Controller\Auth;

/**
 * 管理资讯分类
 * Class Category
 * @package Module\Content\Controller\Info
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
            '__ALL__' => 'CONTENT_INFO_CATEGORY_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $response = $this->api->call('content/info-category/get-tree', $params);
        $this->view->categories = $response->data->children;
        $this->view->render('content/info/category/index');
    }

}