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
 * 管理企业渠道比重
 * Class ChannelWeight
 * @package Module\Producer\Controller\Ajax\Statistics
 */
class ChannelWeight extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STATISTICS_CHANNEL_WEIGHT'
        ];
    }

    /**
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerChannelWeight/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerChannelWeight/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/ProducerChannelWeight/delete', $data);
        $this->export($response);
    }
}