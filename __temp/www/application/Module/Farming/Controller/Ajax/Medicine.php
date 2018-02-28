<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/28
 * Time: 下午10:02
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 渔药信息管理
 * Class Medicine
 * @package Module\Farming\Controller\Ajax
 */
class Medicine extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_MEDICINE_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine/delete', $data);
        $this->export($response);
    }
}