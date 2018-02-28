<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/10
 * Time: 下午10:58
 */

namespace Module\Supervisor\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 投诉管理ajax
 * Class Complaint
 * @package Module\Supervisor\Controller\Ajax
 */
class Complaint extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_COMPLAINT_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/department/delete', $data);
        $this->export($response);
    }
}