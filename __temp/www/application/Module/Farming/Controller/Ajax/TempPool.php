<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/2
 * Time: 下午3:29
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * Class TempPool
 * @package Module\Farming\Controller\Ajax
 */
class TempPool extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_TEMP_POOL_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-temp-pool/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/production-temp-pool/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/production-temp-pool/delete', $data);
        $this->export($response);
    }
}