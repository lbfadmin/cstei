<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 下午12:02
 */

namespace Module\Company\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 管理产品类型ajax
 * Class ProductType
 * @package Module\Project\Controller\Ajax
 */
class DeviceType extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PROJECT_PRODUCT_TYPE_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();

        $response = $this->api->call('producer/device-type/delete', $data);

        $this->export($response);
    }
}