<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 上午11:09
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProductionUnitCreditModel;
use System\Component\Validator\Validator;

/**
 * 企业诚信
 * Class ProductionUnitCredit
 * @package Module\Project\Controller
 */
class ProductionUnitCredit extends Api
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
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        try {
            $id = $productionUnitCreditModel->add($data);
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
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        $context = [
            'productionUnitCreditModel' => $productionUnitCreditModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $productionUnitCreditModel->update($data, ['id=?', [$data['id']]]);
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
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        try {
            $result = $productionUnitCreditModel->delete(['id=?', [$id]]);
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
     * 字段验证
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
        $this->preProcessData($data, ProductionUnitCreditModel::$fields);
        $validator = new Validator();
        $productionUnitCreditModel = $context['productionUnitCreditModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($productionUnitCreditModel) {
                        $item = $productionUnitCreditModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_UNIT_CREDIT'
                        ];
                    }
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
        $unitId = $this->input->getInt('unit_id');
        if (empty($id) && empty($unitId)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        try {
            // 基本信息
            $item = $productionUnitCreditModel->getItem([
                'id' => $id,
                'production_unit_id' => $unitId,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '企业诚信不存在'
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
     * 获取多条
     * @return mixed
     */
    public function getItems()
    {
        $unitIds = $this->input->getString('production_unit_ids');
        $unitIds = empty(trim($unitIds)) ? [] : explode(',', $unitIds);
        if (empty($unitIds)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        try {
            // 基本信息
            $items = $productionUnitCreditModel->getItems([
                'production_unit_ids' => $unitIds,
            ]);
            if (empty($items)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '企业诚信不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'items' => $items
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
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'status' => $this->input->getInt('status'),
            'production_unit_id' => $this->input->getInt('production_unit_id'),
            'production_unit_name' => $this->input->getString('production_unit_name'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $productionUnitCreditModel->getList($params);
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
        $productionUnitCreditModel = new ProductionUnitCreditModel();
        return $this->export([
            'data' => [
                'list' => $productionUnitCreditModel->getAll()
            ]
        ]);
    }
}