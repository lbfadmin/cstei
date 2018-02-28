<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-16
 * Time: 上午10:41
 */

namespace Module\Content\Controller\Ajax\Info;


use Module\Account\Controller\Ajax;

/**
 * 管理资讯
 * Class Info
 * @package Module\Content\Controller\Ajax\Info
 */
class Info extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONTENT_INFO_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('content/info/delete', [
            'id' => $this->input->getInt('id')
        ]);
        $this->export();
    }
}