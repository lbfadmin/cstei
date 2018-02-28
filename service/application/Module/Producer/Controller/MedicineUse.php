<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:21
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\MedicineUseModel;
use System\Component\Validator\Validator;

/**
 * 鱼药投放
 * Class MedicineUse
 * @package Module\Producer\Controller
 */
class MedicineUse extends Api
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
        $medicineUseModel = new MedicineUseModel();
        try {
            $id = $medicineUseModel->add($data);
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
        $medicineUseModel = new MedicineUseModel();
        $context = [
            'medicineUseModel' => $medicineUseModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $medicineUseModel->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, MedicineUseModel::$fields);
        $validator = new Validator();
        $medicineUseModel = $context['medicineUseModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($medicineUseModel) {
                        $item = $medicineUseModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_FEED'
                        ];
                    }
                ]
            ];
        }
        if (!empty($data['amount']) || $action === 'create') {
            $fields[] = [
                'name' => '投放量',
                'value' => $data['amount'],
                'rules' => [
                    'required' => ['code' => 'AMOUNT_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'AMOUNT_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'AMOUNT_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['type']) || $action === 'create') {
            $fields[] = [
                'name' => '投放量',
                'value' => $data['type'],
                'rules' => [
                    'required' => ['code' => 'TYPE_IS_REQUIRED'],
                    'int' => ['code' => 'TYPE_BE_INT']
                ]
            ];
        }

        if (!empty($data['batch_sn']) || $action === 'create') {
            $fields[] = [
                'name' => '批次号',
                'value' => $data['batch_sn'],
                'rules' => [
                    'required' => ['code' => 'BATCH_SN_IS_REQUIRED'],
                    'maxLength' => ['value' => 64, 'code' => 'BATCH_SN_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'BATCH_SN_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['position']) || $action === 'create') {
            $fields[] = [
                'name' => '投放位置',
                'value' => $data['position'],
                'rules' => [
                    'required' => ['code' => 'POSITION_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'POSITION_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'POSITION_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['pool_id']) || $action === 'create') {
            $fields[] = [
                'name' => '养殖池id',
                'value' => $data['pool_id'],
                'rules' => [
                    'required' => ['code' => 'POOL_ID_IS_REQUIRED'],
                    'int' => ['code' => 'POOL_ID_BE_INT']
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
        $medicineUseModel = new MedicineUseModel();
        try {
            // 基本信息
            $item = $medicineUseModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('MEDICINE_NOT_FOUND'),
                    'message' => '鱼药记录不存在'
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
     * 获取批次最新几条
     * @return mixed
     */
    public function getNewest()
    {
        $batchSns = $this->input->getString('batch_sns');
        $batchSns = empty($batchSns) ? [] : explode(',', $batchSns);
        if (empty($batchSns)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少批次号'
            ]);
        }
        $medicineUseModel = new MedicineUseModel();
        try {
            // 基本信息
            $result = $medicineUseModel->getNewestItem([
                'batch_sns' => $batchSns
            ]);

            return $this->export([
                'data' => [
                    'result' => $result
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
        $medicineUseModel = new MedicineUseModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $medicineUseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}