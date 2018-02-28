<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午4:33
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 批次AJAX
 * Class Batch
 * @package Module\Farming\Controller\Ajax
 */
class Batch extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_BATCH_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = $this->company->id;
        $data['pools'] = implode(',', $data['pool_id'] ?: []);
        unset($data['pool_id']);
        $response = $this->api->call('project/batch/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $_POST['pools'] = implode(',', $_POST['pool_id'] ?: []);
        unset($_POST['pool_id']);
        $response = $this->api->call('project/batch/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/batch/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }
}