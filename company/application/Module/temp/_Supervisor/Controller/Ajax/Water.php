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
 * 水质数据ajax
 * Class Water
 * @package Module\Supervisor\Controller\Ajax
 */
class Water extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_WATER_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/water-quality/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/water-quality/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/water-quality/delete', $data);
        $this->export($response);
    }
}