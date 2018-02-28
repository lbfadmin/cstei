<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/27
 * Time: 下午10:15
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 饲料信息管理ajax
 * Class Feed
 * @package Module\Farming\Controller\Ajax
 */
class Feed extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_FEED_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/feed/delete', $data);
        $this->export($response);
    }
}