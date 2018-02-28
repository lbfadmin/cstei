<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:18
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\BreedingPriceModel;
use System\Component\Validator\Validator;

/**
 * 本季度末海水鱼成鱼塘边现价（单位：元/斤）
 * Class AdultFishPrice
 * @package Module\Project\Controller
 */
class AdultFishPrice extends Api
{
   /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
		$page = $page > 0 ? $page : 0;
        $breeding = new BreedingPriceModel();
        $params = [
            'id' => $this->input->getInt('id'),
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
     * 获取汇总数据
     * @return mixed
     */
    public function getSum()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page : 0;
        $breeding = new BreedingPriceModel();
        $params = [
            // 'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
            'unit_ids' => $this->input->getString('unit_ids'),
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
        $this->preProcessData($data, BreedingPriceModel::$fields);
        $breeding = new BreedingPriceModel();
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
        $breeding = new BreedingPriceModel();
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
        $this->preProcessData($data, BreedingPriceModel::$fields);
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
	
        $params = [
            'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
        ];
		// return gettype($params[0]);
		$conditions = array();
		$conditions[] = "unit_id = ".$data['unit_id']." and quarter ='".$data['quarter']."'";
        $breeding = new BreedingPriceModel();
        try {
            $result = $breeding->delete($conditions);

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
        $breeding = new BreedingPriceModel();
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
        $breeding = new BreedingPriceModel();
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
        $breeding = new BreedingPriceModel();
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