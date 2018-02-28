<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:20
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\MedicineModel;
use System\Component\Validator\Validator;

/**
 * 鱼药
 * Class Medicine
 * @package Module\Producer\Controller
 */
class Medicine extends Api
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
        $medicineModel = new MedicineModel();
        try {
            $id = $medicineModel->add($data);
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
        $medicineModel = new MedicineModel();
        $context = [
            'medicineModel' => $medicineModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $medicineModel->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, MedicineModel::$fields);
        $validator = new Validator();
        $medicineModel = $context['medicineModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($medicineModel) {
                        $item = $medicineModel->getItem([
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
        if (!empty($data['storage_life']) || $action === 'create') {
            $fields[] = [
                'name' => '储存期',
                'value' => $data['storage_life'],
                'rules' => [
                    'required' => ['code' => 'STORAGE_LIFE_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'STORAGE_LIFE_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'STORAGE_LIFE_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['suit']) || $action === 'create') {
            $fields[] = [
                'name' => '适用品种',
                'value' => $data['suit'],
                'rules' => [
                    'required' => ['code' => 'SUIT_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'SUIT_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'SUIT_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['applicable_disease']) || $action === 'create') {
            $fields[] = [
                'name' => '适用疾病',
                'value' => $data['applicable_disease'],
                'rules' => [
                    'required' => ['code' => 'APPLICABLE_DISEASE_IS_REQUIRED'],
                    'maxLength' => ['value' => 100, 'code' => 'APPLICABLE_DISEASE_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'APPLICABLE_DISEASE_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['ingredient']) || $action === 'create') {
            $fields[] = [
                'name' => '成分',
                'value' => $data['ingredient'],
                'rules' => [
                    'required' => ['code' => 'INGREDIENT_ID_IS_REQUIRED'],
                    'maxLength' => ['value' => 300, 'code' => 'INGREDIENT_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'INGREDIENT_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['name']) || $action === 'create') {
            $fields[] = [
                'name' => '种类',
                'value' => $data['name'],
                'rules' => [
                    'required' => ['code' => 'NAME_ID_IS_REQUIRED'],
                    'maxLength' => ['value' => 30, 'code' => 'NAME_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'NAME_IS_TOO_SHORT']
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
        $medicineModel = new MedicineModel();
        try {
            // 基本信息
            $item = $medicineModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('MEDICINE_NOT_FOUND'),
                    'message' => '鱼药不存在'
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
        $limit = $this->input->getInt('limit', 20);
        $medicineModel = new MedicineModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $medicineModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}