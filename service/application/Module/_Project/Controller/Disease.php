<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午8:30
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\DiseaseModel;
use System\Component\Validator\Validator;

/**
 * 病害记录
 * Class Disease
 * @package Module\Project\Controller
 */
class Disease extends Api
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
        $diseaseModel = new DiseaseModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s', REQUEST_TIME);
        try {
            $id = $diseaseModel->add($data);
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
        $diseaseModel = new DiseaseModel();
        $context = [
            'diseaseModel' => $diseaseModel
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
            $result = $diseaseModel->update($data, ['id=?', [$data['id']]]);
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
        $diseaseModel = new DiseaseModel();
        try {
            $result = $diseaseModel->delete(['id=?', [$id]]);

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
        $this->preProcessData($data, DiseaseModel::$fields);
        $validator = new Validator();
        $diseaseModel = $context['diseaseModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($diseaseModel) {
                        $item = $diseaseModel->getItem([
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
        $diseaseModel = new DiseaseModel();
        try {
            // 基本信息
            $item = $diseaseModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('FEED_NOT_FOUND'),
                    'message' => '病害记录不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'feed' => $item
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
        $diseaseModel = new DiseaseModel();
        $params = [
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $diseaseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }

}