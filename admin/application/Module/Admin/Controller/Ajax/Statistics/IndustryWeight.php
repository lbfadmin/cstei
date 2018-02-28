<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/6
 * Time: 下午10:54
 */

namespace Module\Producer\Controller\Ajax\Statistics;


use Module\Account\Controller\Ajax;

/**
 * 管理企业产业比重ajax
 * Class IndustryWeight
 * @package Module\Producer\Controller\Ajax\Statistics
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
            '__ALL__' => 'PRODUCER_STATISTICS_INDUSTRY_WEIGHT'
        ];
    }

    /**
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
       // print_r($data);
       // exit;
        $response = $this->api->call('project/breeding-production/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerIndustryWeight/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerIndustryWeight/delete', $data);
        $this->export($response);
    }
}