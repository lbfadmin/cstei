<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 下午12:02
 */

namespace Module\Producer\Controller\Ajax\Company;


use Module\Account\Controller\Ajax;

/**
 * 管理企业信息ajax
 * Class Company
 * @package Module\Producer\Controller\Ajax\Company
 */
class Company extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_COMPANY_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/production-unit/delete', $data);
        $this->export($response);
    }
}