<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/28
 * Time: 下午10:21
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 渔药投放记录管理
 * Class MedicineUse
 * @package Module\Farming\Controller\Ajax
 */
class MedicineUse extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_MEDICINE_USE_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine-use/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine-use/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/medicine-use/delete', $data);
        $this->export($response);
    }
}