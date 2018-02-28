<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-8
 * Time: 下午2:22
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 设备类型ajax
 * Class DeviceType
 * @package Module\Farming\Controller\Ajax
 */
class DeviceType extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_DEVICE_TYPE_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $this->input->getArray();
        if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
            $this->message->set('未选择资质图片', 'error');
            $this->response->refresh();
        }
        $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
        $response = $this->api->call('common/image/upload', $file);
        $data['picture'] = $response->data->key;
        $this->prepare($data);
        $response = $this->api->call('project/device-type/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = $this->input->getArray();
        if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
            $this->message->set('未选择资质图片', 'error');
        }
        if (!empty($_FILES['picture']) && !$_FILES['picture']['error']) {
            $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
            $response = $this->api->call('common/image/upload', $file);
            $data['picture'] = $response->data->key;
        }
        $this->prepare($data);
        $response = $this->api->call('project/device-type/update', $data);
        $this->export($response);
    }

    private function prepare(&$data)
    {
        if (!empty($data['controller_name'])) {
            $controllers = [];
            foreach ($data['controller_name'] as $k => $item) {
                $controllers[$k] = [
                    'name' => $item,
                    'action' => $data['controller_action'][$k]
                ];
            }
            $data['controllers'] = $controllers;
            unset($data['controller_name'], $data['controller_action']);
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        $data = $this->input->getArray();
        $response = $this->api->call('project/device-type/delete', $data);
        $this->export($response);
    }
}