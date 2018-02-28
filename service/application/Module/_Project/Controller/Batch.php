<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:00
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\BatchModel;
use Module\Project\Model\BatchPoolModel;
use System\Component\Validator\Validator;

/**
 * 批次操作
 * Class Batch
 * @package Module\Project\Controller
 */
class Batch extends Api
{

    /**
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
        $pools = $data['pools'];
        $error = $this->validate($data, $pools);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $pools = explode(',', $pools);
        $batchModel = new BatchModel();
        $batchPoolModel = new BatchPoolModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $batchModel->add($data);
            $poolsData = [];
            foreach ($pools as $poolId) {
                $poolsData[] = [
                    'batch_sn' => $data['sn'],
                    'pool_id' => $poolId
                ];
            }
            $batchPoolModel->add($poolsData);
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
        $pools = $data['pools'];
        $batchModel = new BatchModel();
        $batchPoolModel = new BatchPoolModel();
        $error = $this->validate($data, $pools);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $pools = explode(',', $pools);
        $batch = $batchModel->getOne('id,sn', ['id=?', [$data['id']]]);
        try {
            $result = $batchModel->update($data, ['id=?', [$data['id']]]);
            $poolsData = [];
            foreach ($pools as $poolId) {
                $poolsData[] = [
                    'batch_sn' => $batch->sn,
                    'pool_id' => $poolId
                ];
            }
            $batchPoolModel->delete(['batch_sn=?', [$batch->sn]], [], 0);
            $batchPoolModel->add($poolsData);
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
     * @param $pools
     * @return array
     */
    private function validate(array &$data, $pools)
    {
        $this->preProcessData($data, BatchModel::$fields);
        $validator = new Validator();
        $fields = [];
        $fields[] = [
            'name' => '批次号',
            'value' => value($data, 'sn'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '产品种类',
            'value' => value($data, 'product_type_id'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '养殖池',
            'value' => $pools,
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '投放数量',
            'value' => value($data, 'amount'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '预期产量',
            'value' => value($data, 'expect_amount'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '预期收获质量',
            'value' => value($data, 'expect_weight'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '开始养殖时间',
            'value' => value($data, 'date_start'),
            'rules' => [
                'required' => true
            ]
        ];
        $fields[] = [
            'name' => '预计收获时间',
            'value' => value($data, 'date_end'),
            'rules' => [
                'required' => true
            ]
        ];
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
        $batchModel = new BatchModel();
        try {
            $result = $batchModel->delete(['id=?', [$id]]);

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
        $sn = $this->input->getString('sn');
        if (empty($id) && empty($sn)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID或批次号'
            ]);
        }
        $batchModel = new BatchModel();
        try {
            // 基本信息
            if ($id) {
                $item = $batchModel->getOne('*', ['id=?', [$id]]);
            } else {
                $item = $batchModel->getOne('*', ['sn=?', [$sn]]);
            }
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('UNIT_NOT_FOUND'),
                    'message' => '不存在'
                ]);
            }
            $batchModel->formatItems($item);
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
        $batchModel = new BatchModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'product_type_id' => $this->input->getInt('product_type_id'),
            'sn' => $this->input->getString('sn'),
            'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
        ];
        $result = $batchModel->getList($params);
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
        $batchModel = new BatchModel();
        return $this->export([
            'data' => [
                'list' => $batchModel->getAll()
            ]
        ]);
    }
}