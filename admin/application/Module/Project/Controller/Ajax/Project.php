<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 下午3:18
 */

namespace Module\Project\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 管理产品类型分类ajax
 * Class ProductTypeCategory
 * @package Module\Project\Controller\Ajax
 */
class Project extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PROJECT_PRODUCT_TYPE_CATEGORY_MANAGE'
        ];
    }



    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/project/update', $data);
        $this->export($response);
    }

    /**
     * 更新状态
     */
    public function updatestatus()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/project/update-status', $data);
        $this->export($response);
    }
}