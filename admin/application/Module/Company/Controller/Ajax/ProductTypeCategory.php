<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 下午3:18
 */

namespace Module\Project\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 管理产品类型分类ajax
 * Class ProductTypeCategory
 * @package Module\Project\Controller\Ajax
 */
class ProductTypeCategory extends Ajax
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
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/product-type-category/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/product-type-category/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/product-type-category/delete', $data);
        $this->export($response);
    }
}