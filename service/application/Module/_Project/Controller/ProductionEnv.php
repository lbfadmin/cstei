<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午9:51
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProductionEnvModel;
use System\Component\Validator\Validator;

/**
 * 养殖环境
 * Class ProductionEnv
 * @package Module\Project\Controller
 */
class ProductionEnv extends Api
{

    /**
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
					// print_r($data);
			// exit;
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }

        $productionEnvModel = new ProductionEnvModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s', REQUEST_TIME);
        try {
            $id = $productionEnvModel->add($data);
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
        $productionEnvModel = new ProductionEnvModel();
        $context = [
            'productionEnvModel' => $productionEnvModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $data['time_updated'] = date('Y-m-d H:i:s', REQUEST_TIME);
        try {
            $result = $productionEnvModel->update($data, ['id=?', [$data['id']]]);
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
        $productionEnvModel = new ProductionEnvModel();
        try {
            $result = $productionEnvModel->delete(['id=?', [$id]]);

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
        $this->preProcessData($data, ProductionEnvModel::$fields);
        $validator = new Validator();
        $productionEnvModel = $context['productionEnvModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($productionEnvModel) {
                        $item = $productionEnvModel->getItem([
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
        $productionEnvModel = new ProductionEnvModel();
        try {
            // 基本信息
            $item = $productionEnvModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '养殖环境不存在'
                ]);
            }
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'data' => $e->getTrace()
            ]);
        }
        return $this->export([
            'data' => [
                'item' => $item
            ]
        ]);
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
        $productionEnvModel = new ProductionEnvModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'pool_id' => $this->input->getInt('pool_id'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $productionEnvModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

    /**
     * 获取列表
     * @return mixed
     */
    // public function getListLatest()
    // {
        // $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        // $limit = $this->input->getInt('limit', 20);
        // $productionEnvModel = new ProductionEnvModel();
        // $params = [
            // // 'created_start' => $this->input->getString('created_start'),
            // // 'created_end' => $this->input->getString('created_end'),
            // 'pool_id' => $this->input->getInt('pool_id'),
            // 'pager' => [
                // 'page' => $page,
                // 'limit' => $limit
            // ]
        // ];
        // $result = $productionEnvModel->getList($params);
        // return $this->export([
            // 'data' => $result
        // ]);
    // }
	
    /**
     * 获取最新的市场经济
     * @return mixed
     */
    public function getListLatest()
    {
        // $poolIds = $this->input->getString('pool_ids');
        $productionEnvModel = new ProductionEnvModel();
        $list = $productionEnvModel->getListLatest();
        return $this->export([
            'data' => [
                'list' => $list
            ]
        ]);
    }
	
    /**
     * 获取养殖池最新一条
     * @return mixed
     */
    public function getPoolsLatest()
    {
        $poolIds = $this->input->getString('pool_ids');
        $productionEnvModel = new ProductionEnvModel();
        $list = $productionEnvModel->getPoolsLatest($poolIds);
        return $this->export([
            'data' => [
                'list' => $list
            ]
        ]);
    }

}