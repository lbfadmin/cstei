<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 上午11:30
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProjectModel;
use System\Component\Validator\Validator;

/**
 * 项目
 * Class Project
 * @package Module\Project\Controller
 */
class Project extends Api
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
        $projectModel = new ProjectModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $projectModel->add($data);
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
        $projectModel = new ProjectModel();
        $context = [
            'projectModel' => $projectModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $projectModel->update($data, ['id=?', [$data['id']]]);
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
        array $data,
        string $action = 'create',
        array $context = []
    ) {
        $this->preProcessData($data, ProjectModel::$fields);
        $validator = new Validator();
        $hrModel = $context['hrModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($hrModel) {
                        $hr = $hrModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool) $hr,
                            'code' => 'INVALID_HR'
                        ];
                    }
                ]
            ];
        }
        if (!empty($data['name']) || $action === 'create') {
            $fields[] = [
                'name' => '项目名称',
                'value' => $data['name'],
                'rules' => [
                    'required' => ['code' => 'NAME_IS_REQUIRED'],
                    'maxLength' => ['value' => 30, 'code' => 'NAME_IS_TOO_LONG'],
                    'minLength' => ['value' => 2, 'code' => 'NAME_IS_TOO_SHORT']
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
        $projectModel = new ProjectModel();
        try {
            // 基本信息
            $item = $projectModel->getItem([
                'id'  => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('PROJECT_NOT_FOUND'),
                    'message' => '项目不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'project' => $item
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

    }
}