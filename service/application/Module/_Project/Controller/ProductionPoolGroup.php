<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午1:18
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\DeviceGroupModel;
use Module\Project\Model\DeviceModel;
use Module\Project\Model\ProductionPoolGroupModel;
use System\Component\Validator\Validator;

/**
 * 循环水养殖池组管理
 * Class ProductionPoolGroup
 * @package Module\Project\Controller
 */
class ProductionPoolGroup extends Api
{

    /**
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $this->preProcessData($data, ProductionPoolGroupModel::$fields);
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $productionPoolGroupModel->add($data);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
        return $this->export([
            'data' => [
                'id' => $id
            ]
        ]);
    }

    /**
     * 更新
     * @return mixed
     */
    public function update()
    {
        $data = $this->input->getArray();
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $productionPoolGroupModel->update($data, ['id=?', [$data['id']]]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }

    /**
     * 验证字段
     * @param array $data
     * @return array
     */
    private function validate(array &$data) {
        $this->preProcessData($data, ProductionPoolGroupModel::$fields);
        $validator = new Validator();
        $fields[] = [
            'name' => '名称',
            'value' => value($data, 'name'),
            'rules' => [
                'required' => ['code' => 'NAME_IS_REQUIRED'],
                'maxLength' => ['value' => 30, 'code' => 'NAME_IS_TOO_LONG'],
            ]
        ];
        if (!empty($data['description'])) {
            $fields[] = [
                'name' => '说明',
                'value' => value($data, 'description'),
                'rules' => [
                    'maxLength' => ['value' => 300, 'code' => 'DESC_IS_TOO_LONG'],
                ]
            ];
        }
        $validator->validate($fields);
        return $validator->getLastError();
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        try {
            $result = $productionPoolGroupModel->delete(['id=?', [$id]]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }

    /**
     * 获取一条
     * @return mixed
     */
    public function getItem()
    {
        $id = $this->input->getInt('id');
        if (empty($id)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        try {
            // 基本信息
            $item = $productionPoolGroupModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '不存在'
                ]);
            }
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'data' => $e->getTrace()
            ]);
        }
        return $this->export([
            'data' => [
                'item' => $item
            ]
        ]);
    }

    /**
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        return $this->export([
            'data' => [
                'list' => $productionPoolGroupModel->getAll()
            ]
        ]);
    }

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $productionPoolGroupModel = new ProductionPoolGroupModel();
        $params = [
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $productionPoolGroupModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

    /**
     * 获取相关设备
     */
    public function getDevices()
    {
        $id = $this->input->getInt('id');
        if (empty($id)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $deviceGroupModel = new DeviceGroupModel();
        $deviceModel = new DeviceModel();
        $groups = $deviceGroupModel->getAll(['pool_group_id' => $id]);
        if (!empty($groups)) {
            $groupDevices = $deviceModel->getAllByContainer(
                DeviceModel::$containerTypes['DEVICE_GROUP'],
                array_keys($groups)
            );
            if (!empty($groupDevices)) {
                foreach ($groups as &$group) {
                    foreach ($groupDevices as $device) {
                        $group->devices[] = $device;
                    }
                }
            }
        }
        return $this->export([
            'data' => [
                'devices' => array_values($groups)
            ]
        ]);
    }
}