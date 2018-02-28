<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 下午12:02
 */

namespace Module\Producer\Controller\Ajax\Video;


use Module\Account\Controller\Ajax;

/**
 * 管理视频信息ajax
 * Class Company
 * @package Module\Producer\Controller\Ajax\Video
 */
class Company extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_VIDEO_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('producer/video/delete', $data);
        $this->export($response);
    }
}