<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 下午3:18
 */

namespace Module\Content\Controller\Ajax\Info;


use Module\Account\Controller\Ajax;

/**
 * 管理资讯分类
 * Class Category
 * @package Module\Content\Controller\Ajax\Info
 */
class Category extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONTENT_INFO_CATEGORY_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function add()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/info-category/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/info-category/update', $data);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('content/info-category/delete', $data);
        $this->export($response);
    }
}