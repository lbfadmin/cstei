<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午2:45
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\DeviceGroupModel;
use System\Component\Validator\Validator;

/**
 * 循环水养殖-设备组
 * Class DeviceGroup
 * @package Module\Project\Controller
 */
class DeviceGroup extends Api
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
        $this->preProcessData($data, DeviceGroupModel::$fields);
        $deviceGroupModel = new DeviceGroupModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $deviceGroupModel->add($data);
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
        $deviceGroupModel = new DeviceGroupModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $deviceGroupModel->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, DeviceGroupModel::$fields);
        $validator = new Validator();
        $fields[] = [
            'name' => '名称',
            'value' => value($data, 'name'),
            'rules' => [
                'required' => ['code' => 'NAME_IS_REQUIRED'],
                'maxLength' => ['value' => 30, 'code' => 'NAME_IS_TOO_LONG'],
            ]
        ];
        $fields[] = [
            'name' => '循环水养殖池组ID',
            'value' => value($data, 'pool_group_id'),
            'rules' => [
                'required' => ['code' => 'POOL_GROUP_ID_IS_REQUIRED'],
            ]
        ];
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
        $deviceGroupModel = new DeviceGroupModel();
        try {
            $result = $deviceGroupModel->delete(['id=?', [$id]]);
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
        $deviceGroupModel = new DeviceGroupModel();
        try {
            // 基本信息
            $item = $deviceGroupModel->getOne('*', ['id=?', [$id]]);
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
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $deviceGroupModel = new DeviceGroupModel();
        $params = [
            'pool_group_id' => $this->input->getInt('pool_group_id'),
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $deviceGroupModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}