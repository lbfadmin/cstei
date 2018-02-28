<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/25
 * Time: 下午11:20
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\FeedUseModel;
use System\Component\Validator\Validator;

/**
 * 饲料投放
 * Class FeedUse
 * @package Module\Producer\Controller
 */
class FeedUse extends Api
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
        $feedUseModel = new FeedUseModel();
        try {
            $id = $feedUseModel->add($data);
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
        $feedUseModel = new FeedUseModel();
        $context = [
            'feedUseModel' => $feedUseModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $feedUseModel->update($data, ['id=?', [$data['id']]]);
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
        $this->preProcessData($data, FeedUseModel::$fields);
        $validator = new Validator();
        $feedUseModel = $context['feedUseModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($feedUseModel) {
                        $item = $feedUseModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_FEED'
                        ];
                    }
                ]
            ];
        }
        if (!empty($data['amount']) || $action === 'create') {
            $fields[] = [
                'name' => '投放量',
                'value' => $data['amount'],
                'rules' => [
                    'required' => ['code' => 'AMOUNT_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'AMOUNT_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'AMOUNT_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['type']) || $action === 'create') {
            $fields[] = [
                'name' => '饲料种类',
                'value' => $data['type'],
                'rules' => [
                    'required' => ['code' => 'TYPE_IS_REQUIRED'],
                    'int' => ['code' => 'TYPE_BE_INT']
                ]
            ];
        }

        if (!empty($data['batch_sn']) || $action === 'create') {
            $fields[] = [
                'name' => '批次号',
                'value' => $data['batch_sn'],
                'rules' => [
                    'required' => ['code' => 'BATCH_SN_IS_REQUIRED'],
                    'maxLength' => ['value' => 64, 'code' => 'BATCH_SN_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'BATCH_SN_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['position']) || $action === 'create') {
            $fields[] = [
                'name' => '投放位置',
                'value' => $data['position'],
                'rules' => [
                    'required' => ['code' => 'POSITION_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'POSITION_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'POSITION_IS_TOO_SHORT']
                ]
            ];
        }

        if (!empty($data['pool_id']) || $action === 'create') {
            $fields[] = [
                'name' => '养殖池id',
                'value' => $data['pool_id'],
                'rules' => [
                    'required' => ['code' => 'POOL_ID_IS_REQUIRED'],
                    'int' => ['code' => 'POOL_ID_BE_INT']
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
        $feedUseModel = new FeedUseModel();
        try {
            // 基本信息
            $item = $feedUseModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '饲料不存在'
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
     * 获取批次最新几条
     * @return mixed
     */
    public function getNewest()
    {
        $batchSns = $this->input->getString('batch_sns');
        $batchSns = empty($batchSns) ? [] : explode(',', $batchSns);
        if (empty($batchSns)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少批次号'
            ]);
        }
        $feedUseModel = new FeedUseModel();
        try {
            // 基本信息
            $result = $feedUseModel->getNewestItem([
                'batch_sns' => $batchSns
            ]);

            return $this->export([
                'data' => [
                    'result' => $result
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
        $feedUseModel = new FeedUseModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'batch_sn' => $this->input->getString('batch_sn'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $feedUseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}