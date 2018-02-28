<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:00
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\DeviceModel;
use Module\Project\Model\DevicePowerModel;
use System\Component\Validator\Validator;

/**
 * 设备管理
 * Class Device
 * @package Module\Project\Controller
 */
class Device extends Api
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
        $deviceModel = new DeviceModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        $this->prepare($data);
        try {
            $id = $deviceModel->add($data);
            return $this->export([
                'data' => [
                    'id' => $id
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 更新
     * @return mixed
     */
    public function update()
    {
        $data = $this->input->getArray();
        $deviceModel = new DeviceModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $this->prepare($data);
        try {
            $result = $deviceModel->update($data, ['id=?', [$data['id']]]);
            return $this->export([
                'data' => [
                    'result' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 开机
     * @return mixed
     */
    public function powerOn()
    {
        $deviceId = $this->input->getInt('id');
        $deviceModel = new DeviceModel();
        $devicePowerModel = new DevicePowerModel();
        $device = $deviceModel->getOne('id,sn', ['id=?', [$deviceId]]);
        $time = date('Y-m-d H:i:s');
        try {
            $deviceModel->update([
                'status' => 1,
                'time_updated' => $time
            ], ['id=?', [$deviceId]]);
            $devicePowerModel->add([
                'device_sn' => $device->sn,
                'operation' => 1,
                'time_operated' => $time,
                'time_created' => $time
            ]);
            return $this->export([
                'data' => [
                    'result' => 1
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * 关机
     * @return mixed
     */
    public function powerOff()
    {
        $deviceId = $this->input->getInt('id');
        $deviceModel = new DeviceModel();
        $devicePowerModel = new DevicePowerModel();
        $device = $deviceModel->getOne('id,sn', ['id=?', [$deviceId]]);
        $time = date('Y-m-d H:i:s');
        try {
            $deviceModel->update([
                'status' => 3,
                'time_updated' => $time
            ], ['id=?', [$deviceId]]);
            $devicePowerModel->add([
                'device_sn' => $device->sn,
                'operation' => 2,
                'time_operated' => $time,
                'time_created' => $time
            ]);
            return $this->export([
                'data' => [
                    'result' => 1
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * 验证字段
     * @param array $data
     * @return array
     */
    private function validate(array &$data)
    {
        $this->preProcessData($data, DeviceModel::$fields);
        $validator = new Validator();
        $fields = [];
        $validator->validate($fields);
        return $validator->getLastError();
    }

    /**
     * 准备数据
     * @param $data
     */
    private function prepare(&$data)
    {
        if (!is_numeric($data['status'])) {
            $data['status'] = DeviceModel::$statuses[$data['status']];
        }
        if (!is_numeric($data['container_type'])) {
            $data['container_type'] = DeviceModel::$containerTypes[$data['container_type']];
        }
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $deviceModel = new DeviceModel();
        try {
            $result = $deviceModel->delete(['id=?', [$id]]);

            return $this->export([
                'data' => [
                    'result' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage()
            ]);
        }
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
        $deviceModel = new DeviceModel();
        try {
            // 基本信息
            $item = $deviceModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'item' => $item
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'data' => $e->getTrace()
            ]);
        }
    }

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $deviceModel = new DeviceModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'container_type' => value(
                DeviceModel::$containerTypes,
                $this->input->getString('container_type')
            ),
            'container_id' => $this->input->getInt('container_id'),
            'status' => value(
                DeviceModel::$statuses,
                $this->input->getString('status')
            ),
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $deviceModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}