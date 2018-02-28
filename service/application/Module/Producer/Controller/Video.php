<?php
/**
 * Created by PhpStorm.
 * User: yueliang
 * Date: 2017/12/17
 * Time: 下午11:18
 */

namespace Module\Producer\Controller;


use Application\Controller\Api;
use Module\Producer\Model\VideoModel;
use System\Component\Validator\Validator;

/**
 * 饲料
 * Class Video
 * @package Module\Producer\Controller
 */
class Video extends Api
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
        $this->preProcessData($data, VideoModel::$fields);
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');

        $VideoModel = new VideoModel();
        try {
            $id = $VideoModel->add($data);
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
        $VideoModel = new VideoModel();
        $context = [
            'VideoModel' => $VideoModel
        ];
        $error = $this->validate($data, 'update', $context);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $VideoModel->update($data, ['id=?', [$data['id']]]);
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
        $VideoModel = new VideoModel();
        try {
            $result = $VideoModel->delete(['id=?', [$id]]);

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
        $this->preProcessData($data, VideoModel::$fields);
        $validator = new Validator();
        $VideoModel = $context['VideoModel'];
        $fields = [];
        if ($action === 'update') {
            $fields[] = [
                'name' => 'ID',
                'value' => $data['id'],
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED'],
                    'int' => ['code' => 'ID_MUST_BE_INT'],
                    'exists' => function ($field) use ($VideoModel) {
                        $item = $VideoModel->getItem([
                            'fields' => '1',
                            'id' => $field['value']
                        ]);
                        return [
                            'match' => (bool)$item,
                            'code' => 'INVALID_Video'
                        ];
                    }
                ]
            ];
        }
        if (!empty($data['title']) || $action === 'create') {
            $fields[] = [
                'name' => '视频标题',
                'value' => $data['title'],
                'rules' => [
                    'required' => ['code' => 'NAME_IS_REQUIRED'],
                    'maxLength' => ['value' => 50, 'code' => 'NAME_IS_TOO_LONG'],
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
        $VideoModel = new VideoModel();
        try {
            // 基本信息
            $item = $VideoModel->getItem([
                'id' => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('Video_NOT_FOUND'),
                    'message' => '视频不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'Video' => $item
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
        $VideoModel = new VideoModel();
        $params = [
            'title' => $this->input->getString('title'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $VideoModel->getList($params);
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
        $VideoModel = new VideoModel();
        return $this->export([
            'data' => [
                'list' => $VideoModel->getAll()
            ]
        ]);
    }
}