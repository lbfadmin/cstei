<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/1
 * Time: 下午12:32
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\WarehousingModel;
use System\Component\Validator\Validator;

/**
 * 入库记录
 * Class Warehousing
 * @package Module\Project\Controller
 */
class Warehousing extends Api
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
        $warehousingModel = new WarehousingModel();
        try {
            $id = $warehousingModel->add($data);
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
        $warehousingModel = new WarehousingModel();
        $context = [
            'warehousingModel' => $warehousingModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $warehousingModel->update($data, ['id=?', [$data['id']]]);
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
        $warehousingModel = new WarehousingModel();
        try {
            $result = $warehousingModel->delete(['id=?', [$id]]);

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
        $this->preProcessData($data, WarehousingModel::$fields);
        $validator = new Validator();
        $warehousingModel = $context['warehousingModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($warehousingModel) {
                        $item = $warehousingModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_WARE_HOUSE'
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
        $warehousingModel = new WarehousingModel();
        try {
            // 基本信息
            $item = $warehousingModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '入库记录不存在'
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
        $warehousingModel = new WarehousingModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'batch_sn' => $this->input->getString('batch_sn'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $warehousingModel->getList($params);
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
        $warehousingModel = new WarehousingModel();
        return $this->export([
            'data' => [
                'list' => $warehousingModel->getAll()
            ]
        ]);
    }
}