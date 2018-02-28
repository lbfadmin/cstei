<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/8
 * Time: 下午3:21
 */

namespace Module\Supervisor\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 环境污染预警
 * Class Warning
 * @package Module\Supervisor\Controller\Ajax
 */
class Warning extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_WARNING_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/env-warning/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/env-warning/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/env-warning/delete', $data);
        $this->export($response);
    }
}