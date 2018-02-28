<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:10
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\BreedingFryModel;
use System\Component\Validator\Validator;

/**
 * 试验站
 * Class BreedingFry
 * @package Module\Producer\Controller
 */
class BreedingFry extends Api
{
	
   /**
     * 获取统计数据
     * @return mixed
     */
    public function getSum()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page : 0;
        $breeding = new BreedingFryModel();
        $params = [
            // 'unit_id' => $this->input->getInt('unit_id'),
            'unit_ids' => $this->input->getString('unit_ids'),
            'quarter' => $this->input->getString('quarter'),
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $breeding->getSum($params);
        return $this->export([
            'data' => $result
        ]);
    }
	
   /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        $page = $page > 0 ? $page : 0;
        $breeding = new BreedingFryModel();
        $params = [
            'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
            'unit_ids' => $this->input->getString('unit_ids'),            
			'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
            // 'page' => $page,
            // 'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $breeding->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
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
        $this->preProcessData($data, BreedingFryModel::$fields);
        $breeding = new BreedingFryModel();
        try {
            $id = $breeding->add($data);
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
        $breeding = new BreedingFryModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $breeding->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, BreedingFryModel::$fields);
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
        $data = $this->input->getArray();    

		$conditions = array();
		$conditions[] = "unit_id = ".$data['unit_id']." and quarter ='".$data['quarter']."'";

            // return $this->export([
                // 'data' => [
                    // 'result' => $conditions
                // ]
            // ]);
        $breeding = new BreedingFryModel();
        try {
            $result = $breeding->delete($conditions);

            return $this->export([
                'data' => [
                    'result' => $data
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
        $breeding = new BreedingFryModel();
        try {
            // 基本信息
            $item = $breeding->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '生产单位不存在'
                ]);
            }
            $breeding->formatItems($item);
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
        $breeding = new BreedingFryModel();
        try {
            // 基本信息
            $items = $breeding->getItems([
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

 
     /* 获取列表
     * @return mixed
     */
    public function getAll()
    {
        // $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        $breeding = new BreedingFryModel();
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