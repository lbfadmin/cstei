<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-12-19
 * Time: 下午10:06
 */

namespace Module\Content\Controller;


use Application\Component\Util\Tree;
use Application\Controller\Api;
use Module\Content\Model\InfoCategoryModel;
use Module\Content\Model\InfoModel;
use System\Component\Validator\Validator;

/**
 * 资讯分类
 * Class Category
 * @package Module\Content\Controller
 
	 http://127.0.0.1:11034/content/Info-Category/getChildren
 */
class InfoCategory extends Api
{

    /**
     * 添加分类
     * @return mixed
     */
    public function create()
    {
        $data = $_POST;
        $this->preProcessData($data, InfoCategoryModel::$fields);
        $validator = new Validator();
        $fields['name'] = array(
            'name'  => '名称',
            'value' => $data['name'],
            'rules' => array(
                'required' => []
            )
        );
        $validator->validate($fields);
        $error = $validator->getLastError();
        if ($error) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        unset($data['id']);
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        $infoCategoryModel = new InfoCategoryModel();
        try {
            $id = $infoCategoryModel->add($data);
            return $this->export([
                'data' => [
                    'id' => $id
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
     * 更新分类
     * @return mixed
     */
    public function update()
    {
        $data = $_POST;
        $this->preProcessData($data, InfoCategoryModel::$fields);
        // 禁止修改父类
        unset($data['parentId']);
        $validator = new Validator();
        $fields['name'] = array(
            'name'  => '名称',
            'value' => $data['name'],
            'rules' => array(
                'required' => []
            )
        );
        $validator->validate($fields);
        $error = $validator->getLastError();
        if ($error) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $data['time_updated'] = date('Y-m-d H:i:s');
        $infoCategoryModel = new InfoCategoryModel();
        try {
            $affects = $infoCategoryModel->update($data, ['id=?', [$data['id']]]);
            return $this->export([
                'data' => [
                    'result' => $affects
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
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $data = $_POST;
        $this->preProcessData($data, InfoCategoryModel::$fields);
        $infoCategoryModel = new InfoCategoryModel();
        $validator = new Validator();
        $category = new \stdClass();
        $fields[] = [
            'name' => '类目ID',
            'value' => $data['id'],
            'rules' => [
                'required' => ['code' => 'CATEGORY_ID_IS_REQUIRED'],
                'exists' => function ($field) use ($infoCategoryModel, &$category) {
                    $category = $infoCategoryModel->getItem([
                        'fields' => 'id',
                        'id' => $field['value']
                    ]);
                    return [
                        'match' => (bool) $category,
                        'code' => 'INVALID_CATEGORY',
                        'message' => '类目不存在'
                    ];
                },
                'hasChildren' => function ($field) use ($infoCategoryModel) {
                    $category = $infoCategoryModel->getItem([
                        'parent_id' => $field['value'],
                        'fields' => '1'
                    ]);
                    return [
                        'match' => !(bool) $category,
                        'code' => 'CATEGORY_HAS_CHILDREN',
                        'message' => '类目下有子类目，不能删除!'
                    ];
                }
            ]
        ];
        $validator->validate($fields);
        $error = $validator->getLastError();
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $infoCategoryModel->delete(['id=?', [$data['id']]]);
            return $this->export();
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 获取子类目
     * @return mixed
     */
    public function getChildren()
    {
        $parentId = (int) trim($_REQUEST['parentId']);
		// echo $parentId;
		// exit;
        $modelJobCategory = new InfoCategoryModel();
        try {
            $result = $modelJobCategory->getAll([
                'parent_id' => $parentId
            ]);
            return $this->export([
                'data' => [
                    'children' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'data' => [
                    'children' => []
                ]
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
                'code' => $this->code('INVALID_ID'),
                'message' => 'ID无效'
            ]);
        }
        $modelJobCategory = new InfoCategoryModel();
        try {
            $category = $modelJobCategory->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'category' => $category
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
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $modelJobCategory = new InfoCategoryModel();
        try {
            $result = $modelJobCategory->getAll([
                'fields' => $_REQUEST['fields'] ?: '*'
            ]);
            return $this->export([
                'data' => [
                    'categories' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'data' => [
                    'categories' => []
                ]
            ]);
        }
    }

    /**
     * 获取类目树
     */
    public function getTree()
    {
        $categoryId = $this->input->getInt('id', 0);
        $infoCategoryModel = new InfoCategoryModel();
        $treeCom = new Tree();
        $treeCom->setOptions([
            'primaryKey' => 'id',
            'parentKey' => 'parent_id'
        ]);
        try {
            $result = $infoCategoryModel->getAll();
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