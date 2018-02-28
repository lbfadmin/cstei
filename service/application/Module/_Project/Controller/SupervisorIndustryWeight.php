<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午9:28
 */

namespace Module\Project\Controller;


use Application\Component\Util\Tree;
use Application\Controller\Api;
use Module\Project\Model\SupervisorIndustryWeightModel;
use System\Component\Validator\Validator;

/**
 * 政府-行业比重报告
 * Class SupervisorIndustryWeight
 * @package Module\Project\Controller
 */
class SupervisorIndustryWeight extends Api
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
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        try {
            $id = $supervisorIndustryWeightModel->add($data);
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
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        $context = [
            'supervisorIndustryWeightModel' => $supervisorIndustryWeightModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $supervisorIndustryWeightModel->update($data, ['id=?', [$data['id']]]);
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
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        try {
            $result = $supervisorIndustryWeightModel->delete(['id=?', [$id]]);

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
        $this->preProcessData($data, SupervisorIndustryWeightModel::$fields);
        $validator = new Validator();
        $supervisorIndustryWeightModel = $context['supervisorIndustryWeightModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($supervisorIndustryWeightModel) {
                        $item = $supervisorIndustryWeightModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_ENV'
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
        if (empty($id)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        try {
            // 基本信息
            $item = $supervisorIndustryWeightModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('ITEM_NOT_FOUND'),
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
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $limit = $this->input->getInt('limit', 20);
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'truck_id' => $this->input->getInt('truck_id'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $supervisorIndustryWeightModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

    /**
     * 获取类目树
     */
    public function getTree()
    {
        $categoryId = $this->input->getInt('id', 0);
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        $treeCom = new Tree();
        $treeCom->setOptions([
            'primaryKey' => 'id',
            'parentKey' => 'parent_id'
        ]);
        try {
            $result = $supervisorIndustryWeightModel->getAll();
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

    /**
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $supervisorIndustryWeightModel = new SupervisorIndustryWeightModel();
        return $this->export([
            'data' => [
                'list' => $supervisorIndustryWeightModel->getAll()
            ]
        ]);
    }
}