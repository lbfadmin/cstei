<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-23
 * Time: 下午3:13
 */

namespace Module\Supervisor\Controller;


use Application\Controller\Api;
use Module\Supervisor\Model\SpotCheckModel;
use System\Component\Validator\Validator;

/**
 * 专家诊断
 * Class SpotCheck
 * @package Module\Supervisor\Controller
 */
class SpotCheck extends Api
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
        $spotCheckModel = new SpotCheckModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        $this->prepare($data);
        try {
            $id = $spotCheckModel->add($data);
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
        $spotCheckModel = new SpotCheckModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $this->prepare($data);
        try {
            $result = $spotCheckModel->update($data, ['id=?', [$data['id']]]);
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
     * @param $data
     * @return array
     */
    private function validate(&$data)
    {
        $this->preProcessData($data, SpotCheckModel::$fields);
        $validator = new Validator();
        $fields = [];
        $validator->validate($fields);
        return $validator->getLastError();
    }

    /**
     * 准备数据
     * @param $data
     */
    private function prepare(&$data)
    {
        if (isset($data['status'])) {
            $data['status'] = SpotCheckModel::$statuses[$data['status']];
        }
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $spotCheckModel = new SpotCheckModel();
        try {
            $result = $spotCheckModel->delete(['id=?', [$id]]);
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
        $spotCheckModel = new SpotCheckModel();
        try {
            // 基本信息
            $item = $spotCheckModel->getOne('*', ['id=?', [$id]]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('ITEM_NOT_FOUND'),
                    'message' => '部门不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'check' => $item
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
    public function getItems() {
        $unitIds = $this->input->getString('production_unit_ids');
        $unitIds = empty(trim($unitIds)) ? [] : explode(',', $unitIds);
        if (empty($unitIds)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $spotCheckModel = new SpotCheckModel();
        try {
            // 基本信息
            $items = $spotCheckModel->getItems([
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
        $spotCheckModel = new SpotCheckModel();
        $status = $this->input->getString('status');
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'progress' => $this->input->getInt('progress'),
            'status' => SpotCheckModel::$statuses[$status],
            'production_unit_id' => $this->input->getInt('production_unit_id'),
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $spotCheckModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}