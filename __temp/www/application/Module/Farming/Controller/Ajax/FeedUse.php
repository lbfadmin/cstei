<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/27
 * Time: 下午10:53
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 饲料投放记录管理
 * Class FeedUse
 * @package Module\Farming\Controller\Ajax
 */
class FeedUse extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_FEED_USE_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed-use/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed-use/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed-use/delete', $data);
        $this->export($response);
    }
}