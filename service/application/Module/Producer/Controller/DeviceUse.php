<?php
/**
 * Created by PhpStorm.
 * User: yueliang
 * Date: 2017/12/17
 * Time: 下午11:18
 */

namespace Module\Producer\Controller;
use Application\Controller\Api;
use Module\Producer\Model\DeviceUseModel;
use System\Component\Validator\Validator;

/**
 * 饲料
 * Class DeviceUse
 * @package Module\Producer\Controller
 */
class DeviceUse extends Api
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
        $this->preProcessData($data, DeviceUseModel::$fields);

        $data['time_apply']=$data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');

        $DeviceUseModel = new DeviceUseModel();
        try {
            $id = $DeviceUseModel->add($data);
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
        $DeviceUseModel = new DeviceUseModel();
        $context = [
            'DeviceUseModel' => $DeviceUseModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $DeviceUseModel->update($data, ['id=?', [$data['id']]]);
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
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $DeviceUseModel = new DeviceUseModel();
        try {
            $result = $DeviceUseModel->delete(['id=?', [$id]]);

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
     * 修改使用状态
     * @return mixed
     */
    public function useStatus()
    {
        $id = $this->input->getInt('id');
        $data['status']=$this->input->getInt('status');
        $DeviceUseModel = new DeviceUseModel();
        try {
            $result = $DeviceUseModel->update($data, ['id=?', [$id]]);
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
     * 验证字段
     * @param array $data
     * @param string $action
     * @param array $context
     * @return array
     */
    private function validate(
        array & $data,
        $action = 'create',
        array $context = []
    )
    {
        $this->preProcessData($data, DeviceUseModel::$fields);
        $validator = new Validator();
        $DeviceUseModel = $context['DeviceUseModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($DeviceUseModel) {
                        $item = $DeviceUseModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_DEVICE_USE'
                        ];
                    }
                ]
            ];
        }
        if (isset($data['yongtu']) || $create) {
            $fields[] = [
                'name' => '用途',
                'value' => value($data, 'yongtu'),
                'rules' => [
                    'required' => ['code' => 'BODY_IS_REQUIRED'],
                    'maxLength' => ['value' => 255, 'code' => 'BODY_IS_TOO_LONG']
                ]
            ];
        }
        if (isset($data['time_start']) || $create) {
            $fields[] = [
                'name' => '开始时间',
                'value' => value($data, 'time_start'),
                'rules' => [
                    'required' => ['code' => 'BODY_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['time_end']) || $create) {
            $fields[] = [
                'name' => '开始时间',
                'value' => value($data, 'time_end'),
                'rules' => [
                    'required' => ['code' => 'BODY_IS_REQUIRED']
                ]
            ];
        }

        $validator->validate($fields);
        return $validator->getLastError();
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
        $DeviceUseModel = new DeviceUseModel();
        try {
            // 基本信息
            $item = $DeviceUseModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('DeviceUse_NOT_FOUND'),
                    'message' => '设备使用申请不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'DeviceUse' => $item
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
        $limit = $this->input->getInt('limit', 20);
        $DeviceUseModel = new DeviceUseModel();
        $params = [
            'status' => $this->input->getInt('status'),
            'device_id' => $this->input->getInt('device_id'),
            'company_id' => $this->input->getInt('company_id'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $DeviceUseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
    /**
     * 根据公司company_id获取列表
     * @return mixed
     */
    public function getCompanyList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $limit = $this->input->getInt('limit', 20);
        $DeviceUseModel = new DeviceUseModel();
        $params = [
            'status' => $this->input->getInt('status'),
            'device_id' => $this->input->getInt('device_id'),
            'company_id' => $_SESSION['user']->unit_id,
           // 'company_id' =>  $company_id,
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $DeviceUseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

    /**
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $DeviceUseModel = new DeviceUseModel();
        return $this->export([
            'data' => [
                'list' => $DeviceUseModel->getAll()
            ]
        ]);
    }
}