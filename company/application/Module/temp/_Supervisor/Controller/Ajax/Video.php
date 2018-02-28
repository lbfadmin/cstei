<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/8
 * Time: 下午3:21
 */

namespace Module\Supervisor\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 视频数据ajax
 * Class Video
 * @package Module\Supervisor\Controller\Ajax
 */
class Video extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_VIDEO_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/video/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/video/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('supervisor/video/delete', $data);
        $this->export($response);
    }
}