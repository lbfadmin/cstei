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
 * 循环水养殖池组ajax
 * Class PoolGroup
 * @package Module\Farming\Controller\Ajax
 */
class PoolGroup extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_POOL_GROUP_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-pool-group/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/production-pool-group/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/production-pool-group/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }

    /**
     * 获取详情
     */
    public function getDetail()
    {
        $id = $this->input->getInt('id');
        // 养殖池组
        $response = $this->api->call('project/production-pool-group/get-item', [
            'id' => $id
        ]);
        $group = $response->data->item;
        // 养殖池
        $response = $this->api->call('project/production-pool/get-all', [
            'group_id' => $id
        ]);
        $pools = $response->data->list;
        // 设备
        $response = $this->api->call('project/production-pool-group/get-devices', [
            'id' => $id
        ]);
        $deviceGroups = $response->data->devices;
        $deviceTypes = [];
        // 设备类型
        if (!empty($deviceGroups)) {
            $typeIds = [];
            foreach ($deviceGroups as $group) {
                if (!empty($group->devices)) {
                    foreach ($group->devices as $device) {
                        $typeIds[$device->type_id] = $device->type_id;
                    }
                }
            }
            if (!empty($typeIds)) {
                $response = $this->api->call('project/device-type/get-items', [
                    'ids' => implode(',', $typeIds)
                ]);
                $deviceTypes = $response->data->items;
            }
        }
        $this->export([
            'data' => [
                'group' => $group,
                'pools' => $pools,
                'device_groups' => $deviceGroups,
                'device_types' => $deviceTypes
            ]
        ]);
    }
}