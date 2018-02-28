<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 下午12:02
 */

namespace Module\Consumer\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 购买/评价ajax
 * Class Purchase
 * @package Module\Consumer\Controller\Ajax
 */
class Purchase extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_PURCHASE_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/purchase/delete', $data);
        $this->export($response);
    }
}