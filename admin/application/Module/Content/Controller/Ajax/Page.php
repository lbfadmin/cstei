<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 下午4:36
 */

namespace Module\Content\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 管理页面
 * Class Page
 * @package Module\Content\Controller\Ajax
 */
class Page extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONTENT_PAGE_MANAGE'
        ];
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('content/page/delete', [
            'id' => $this->input->getInt('id')
        ]);
        $this->export($response);
    }
}