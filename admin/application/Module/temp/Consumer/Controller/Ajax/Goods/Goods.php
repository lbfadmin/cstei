<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 上午10:32
 */

namespace Module\Consumer\Controller\Ajax\Goods;


use Module\Account\Controller\Ajax;

/**
 * 商品ajax
 * Class Goods
 * @package Module\Consumer\Controller\Ajax\Goods
 */
class Goods extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_GOODS_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/goods/delete', $data);
        $this->export($response);
    }
}