<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/6
 * Time: 下午10:54
 */

namespace Module\Supervisor\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 行业分布ajax
 * Class IndustryWeight
 * @package Module\Supervisor\Controller\Ajax
 */
class IndustryWeight extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_INDUSTRY_WEIGHT_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/SupervisorIndustryWeight/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/SupervisorIndustryWeight/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/SupervisorIndustryWeight/delete', $data);
        $this->export($response);
    }
}