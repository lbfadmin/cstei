<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:10
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProductionUnitModel;
use System\Component\Validator\Validator;

/**
 * 试验站
 * Class ProductionUnit
 * @package Module\Project\Controller
 */
class ProductionUnit extends Api
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
        $this->preProcessData($data, ProductionUnitModel::$fields);
        $productionUnitModel = new ProductionUnitModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $productionUnitModel->add($data);
            return $this->export([
                'data' => [
                    'id' => $id
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                // 'message' => $data,
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
        $productionUnitModel = new ProductionUnitModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $productionUnitModel->update($data, ['id=?', [$data['id']]]);
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
    private function validate(array &$data) {
        $this->preProcessData($data, ProductionUnitModel::$fields);
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
        $productionUnitModel = new ProductionUnitModel();
        try {
            $result = $productionUnitModel->delete(['id=?', [$id]]);

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
    public function getStation()
    {
        $name = $this->input->getString('name');
        if (empty($name)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少试验站名称'
            ]);
        }
        $productionUnitModel = new ProductionUnitModel();
        try {
            // 基本信息
            $item = $productionUnitModel->getOne('*', ['name=?', [$name]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '试验站不存在'
                ]);
            }
            $productionUnitModel->formatItems($item);
            return $this->export([
                'data' => [
                    'production_unit' => $item
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
        $productionUnitModel = new ProductionUnitModel();
        try {
            // 基本信息
            $item = $productionUnitModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '生产单位不存在'
                ]);
            }
            $productionUnitModel->formatItems($item);
            return $this->export([
                'data' => [
                    'production_unit' => $item
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
        $unitIds = $this->input->getString('ids');
        $unitIds = empty(trim($unitIds)) ? [] : explode(',', $unitIds);
        if (empty($unitIds)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $productionUnitModel = new ProductionUnitModel();
        try {
            // 基本信息
            $items = $productionUnitModel->getItems([
                'ids' => $unitIds,
            ]);
            if (empty($items)) {
                return $this->export([
                    'code' => $this->code('ITEMS_NOT_FOUND'),
                    'message' => '企业不存在'
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
        $productionUnitModel = new ProductionUnitModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'name' => $this->input->getString('name'),
            'parent_id' => $this->input->getInt('parent_id'),
            'province_id' => $this->input->getInt('province_id'),
            'city_id' => $this->input->getInt('city_id'),
            'district_id' => $this->input->getInt('district_id'),
            'address' => $this->input->getString('address'),//试验站地址
            'block_id' => $this->input->getInt('block_id'),
            'community_id' => $this->input->getInt('community_id'),
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $productionUnitModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
     /* 获取列表
     * @return mixed
     */
    public function getAll()
    {
        // $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        $productionUnitModel = new ProductionUnitModel();
        $params = [
            // 'created_start' => $this->input->getString('created_start'),
            // 'created_end' => $this->input->getString('created_end'),
            'name' => $this->input->getString('name'),
            'province_id' => $this->input->getInt('province_id'),
            'city_id' => $this->input->getInt('city_id'),
            'district_id' => $this->input->getInt('district_id'),
            'address' => $this->input->getString('address'),//试验站地址
            // 'block_id' => $this->input->getInt('block_id'),
            // 'community_id' => $this->input->getInt('community_id'),
            // 'page' => $page,
            // 'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $productionUnitModel->getAll($params);
        return $this->export([
            'data' => $result
        ]);
    }
}