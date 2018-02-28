<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 下午3:18
 */

namespace Module\Consumer\Controller\Ajax\Goods;


use Module\Account\Controller\Ajax;

/**
 * 商品类目ajax
 * Class Category
 * @package Module\Consumer\Controller\Ajax\Goods
 */
class Category extends Ajax
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
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/goods-category/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/goods-category/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/goods-category/delete', $data);
        $this->export($response);
    }
}