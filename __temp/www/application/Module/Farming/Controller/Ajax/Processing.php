<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/2
 * Time: 下午3:30
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 加工记录管理
 * Class Processing
 * @package Module\Farming\Controller\Ajax
 */
class Processing extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_PROCESSING_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-processing/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/production-processing/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/production-processing/delete', $data);
        $this->export($response);
    }
}