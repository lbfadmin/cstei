<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:12
 */

namespace Module\Project\Controller;


use Application\Component\Util\Tree;
use Application\Controller\Api;
use Module\Project\Model\ProductionPoolCategoryModel;
use System\Component\Validator\Validator;

/**
 * 养殖池分组
 * Class ProductionPoolCategory
 * @package Module\Project\Controller
 */
class ProductionPoolCategory extends Api
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
        $this->preProcessData($data, ProductionPoolCategoryModel::$fields);
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $productionPoolCategoryModel->add($data);
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
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $productionPoolCategoryModel->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, ProductionPoolCategoryModel::$fields);
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
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        try {
            $result = $productionPoolCategoryModel->delete(['id=?', [$id]]);

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
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        try {
            // 基本信息
            $item = $productionPoolCategoryModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '不存在'
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
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        return $this->export([
            'data' => [
                'list' => $productionPoolCategoryModel->getAll()
            ]
        ]);
    }

    /**
     * 获取类目树
     */
    public function getTree()
    {
        $categoryId = $this->input->getInt('id', 0);
        $productionPoolCategoryModel = new ProductionPoolCategoryModel();
        $treeCom = new Tree();
        $treeCom->setOptions([
            'primaryKey' => 'id',
            'parentKey' => 'parent_id'
        ]);
        try {
            $result = $productionPoolCategoryModel->getAll();
            $treeCom->setData($result);
            $tree = $treeCom->get($categoryId);
            return $this->export([
                'data' => [
                    'children' => $tree ?: []
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }
}