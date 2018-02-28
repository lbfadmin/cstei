<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:18
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\BreedingAreaModel;
use System\Component\Validator\Validator;

/**
 * 试验站
 * Class BreedingArea
 * @package Module\Project\Controller
 */
class BreedingArea extends Api
{
   /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        // $data = $this->input->getArray();
        $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        $page = $page > 0 ? $page : 0;
        $breeding = new BreedingAreaModel();
        $params = [
            'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
            'unit_ids' => $this->input->getString('unit_ids'),//$data['unit_ids'],
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
     * 获取统计数据
     * @return mixed
     */
    public function getSum()
    {
		
        // $data = $this->input->getArray();
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page : 0;
        $breeding = new BreedingAreaModel();
        $params = [
            // 'unit_id' => $this->input->getInt('unit_id'),
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
     * 获取统计数据
     * @return mixed
     */
    public function getTotal()
    {
		
        // $data = $this->input->getArray();
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $breeding = new BreedingAreaModel();
        $params = [
            'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
            // 'unit_ids' => $this->input->getString('unit_ids'),//$data['unit_ids'],
            // 'unit_ids' => $data['unit_ids'],
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $breeding->getTotal($params);
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
        $this->preProcessData($data, BreedingAreaModel::$fields);
        $breeding = new BreedingAreaModel();
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
        $breeding = new BreedingAreaModel();
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
        $this->preProcessData($data, BreedingAreaModel::$fields);
        $validator = new Validator();
        $fields = [];
/*
        if (!$create) {//修改的场合，id必须存在
            $fields[] = [
                'name' => 'ID',
                'value' => value($data, 'id'),
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['池塘养殖'])) {
            $fields[] = [
                'name' => '池塘养殖',
                'value' => value($data, '池塘养殖'),
                'rules' => [
                    'int' => ['code' => 'CATEGORY_ID_MUST_BE_INT']
                ]
            ];
        }
*/
        // if (isset($data['status'])) {
            // $fields[] = [
                // 'name' => '网箱养殖',
                // 'value' => value($data, '网箱养殖'),
                // 'rules' => [
                    // 'valid' => function ($field) {
                        // return [
                            // 'match' => isset(InfoModel::$statuses[$field['value']]),
                            // 'code' => 'INVALID_STATUS',
                        // ];
                    // }
                // ]
            // ];
        // }
        // if (isset($data['title']) || $create) {
            // $fields[] = [
                // 'name' => '标题',
                // 'value' => value($data, 'title'),
                // 'rules' => [
                    // 'required' => ['code' => 'TITLE_IS_REQUIRED']
                // ]
            // ];
        // }
        // if ($create) {
            // $fields[] = [
                // 'name' => '缩略图',
                // 'value' => value($data, 'picture'),
                // 'rules' => [
                    // 'required' => ['code' => 'PICTURE_IS_REQUIRED']
                // ]
            // ];
        // }
        if (isset($data['body']) || $create) {
            $fields[] = [
                'name' => '正文',
                'value' => value($data, 'body'),
                'rules' => [
                    'required' => ['code' => 'BODY_IS_REQUIRED'],
                    'maxLength' => ['value' => 64000, 'code' => 'BODY_IS_TOO_LONG']
                ]
            ];
        }
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
        $breeding = new BreedingAreaModel();
        try {
            $result = $breeding->delete(['id=?', [$id]]);

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
     * 获取列表
     * @return mixed
     */
    public function isExist()
    {

        $breeding = new BreedingAreaModel();
        $params = [
            'unit_id' => $this->input->getInt('unit_id'),
            'quarter' => $this->input->getString('quarter'),
            'id' => $this->input->getInt('id')
        ];
        $result = $breeding->getItem($params);
        return $this->export([
            'data' => $result
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
        $breeding = new BreedingAreaModel();
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
        $breeding = new BreedingAreaModel();
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
        $breeding = new BreedingAreaModel();
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