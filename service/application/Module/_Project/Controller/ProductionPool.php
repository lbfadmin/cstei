<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午3:43
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProductionPoolModel;
use System\Component\Validator\Validator;

/**
 * 养殖池
 * Class ProductionPool
 * @package Module\Project\Controller
 */
class ProductionPool extends Api
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
        $this->preProcessData($data, ProductionPoolModel::$fields);
        $productionPoolModel = new ProductionPoolModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $productionPoolModel->add($data);
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
        $productionPoolModel = new ProductionPoolModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $productionPoolModel->update($data, ['id=?', [$data['id']]]);
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
     * @return array
     */
    private function validate(array &$data)
    {
        $this->preProcessData($data, ProductionPoolModel::$fields);
        $validator = new Validator();
        $fields = [];
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
        $productionPoolModel = new ProductionPoolModel();
        try {
            $result = $productionPoolModel->delete(['id=?', [$id]]);

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
        $productionPoolModel = new ProductionPoolModel();
        try {
            // 基本信息
            $item = $productionPoolModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '生产单位不存在'
                ]);
            }
            $productionPoolModel->formatItems($item);
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
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $productionUnitId = $this->input->getInt('production_unit_id');
        $productionPoolModel = new ProductionPoolModel();
        return $this->export([
            'data' => [
                'list' => $productionPoolModel->getAll([
                    'production_unit_id' => $productionUnitId,
                    'category_id' => $this->input->getInt('category_id'),
                    'group_id' => $this->input->getInt('group_id'),
                ])
            ]
        ]);
    }

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $productionUnitId = $this->input->getInt('production_unit_id');
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $productionPoolModel = new ProductionPoolModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'status' => $this->input->getInt('status'),
            'category_id' => $this->input->getInt('category_id'),
            'group_id' => $this->input->getInt('group_id'),
            'product_type_id' => $this->input->getInt('product_type_id'),
            'id' => $this->input->getInt('id'),
            'name' => $this->input->getString('name'),
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $productionPoolModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

}