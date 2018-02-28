<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-6-23
 * Time: 下午1:30
 */

namespace Module\Content\Controller;


use Application\Controller\Api;
use Module\Content\Model\PageModel;
use System\Component\Validator\Validator;

/**
 * 静态页操作
 * Class Page
 * @package Module\Content\Controller
 */
class Page extends Api
{

    /**
     * 创建页面
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
        $data['body'] = $_REQUEST['body'];
        $error = $this->validate($data);
        if ($error) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $pageModel = new PageModel();
        $data['time_created'] =
        $data['time_updated'] = date('Y-m-d H:i:s');
        if (empty($data['time_published'])) {
            $data['time_published'] = $data['time_created'];
        }
        if (empty($data['status'])) {
            $data['status'] = 'DRAFT';
        }
        unset($data['id']);
        $this->prepareData($data);
        try {
            $id = $pageModel->add($data);

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
     * 更新
     * @return mixed
     */
    public function update()
    {
        $data = $this->input->getArray();
        $data['body'] = $_REQUEST['body'];
        $error = $this->validate($data, false);
        if ($error) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $pageModel = new PageModel();
        $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $this->prepareData($data);
            $result = $pageModel->update($data, ['id=?', [$data['id']]]);

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
     * @param bool $create
     * @param array $context
     * @return array
     */
    private function validate(array &$data, $create = true, array &$context = [])
    {
        $this->preProcessData($data, PageModel::$fields);
        $validator = new Validator();
        $fields = [];
        if (!$create) {
            $fields[] = [
                'name' => 'ID',
                'value' => value($data, 'id'),
                'rules' => [
                    'required' => ['code' => 'ID_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['category_id'])) {
            $fields[] = [
                'name' => '分类',
                'value' => value($data, 'category_id'),
                'rules' => [
                    'int' => ['code' => 'CATEGORY_ID_MUST_BE_INT']
                ]
            ];
        }
        if (isset($data['status'])) {
            $fields[] = [
                'name' => '状态',
                'value' => value($data, 'status'),
                'rules' => [
                    'valid' => function ($field) {
                        return [
                            'match' => isset(PageModel::$statuses[$field['value']]),
                            'code' => 'INVALID_STATUS',
                        ];
                    }
                ]
            ];
        }
        if (isset($data['title']) || $create) {
            $fields[] = [
                'name' => '标题',
                'value' => value($data, 'title'),
                'rules' => [
                    'required' => ['code' => 'TITLE_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['body']) || $create) {
            $fields[] = [
                'name' => '正文',
                'value' => value($data, 'body'),
                'rules' => [
                    'required' => ['code' => 'BODY_IS_REQUIRED'],
                    'maxLength' => ['value' => 64000, 'code' => 'BODY_IS_TOO_LONG']
                ]
            ];
        }
        $validator->validate($fields);

        return $validator->getLastError();
    }

    /**
     * 准备数据
     * @param $data
     */
    private function prepareData(&$data)
    {
        if (isset($data['time_published'])) {
            $data['time_published'] = date('Y-m-d H:i:s', strtotime($data['time_published']));
        }
        if (isset($data['status'])) {
            $data['status'] = PageModel::$statuses[$data['status']];
        }
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $pageModel = new PageModel();
        try {
            $result = $pageModel->delete(['id=?', [$id]]);

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
        if (empty($id)) {
            return $this->export([
                'code' => $this->code('INVALID_ID'),
                'message' => 'ID无效'
            ]);
        }
        $pageModel = new PageModel();
        try {
            $page = $pageModel->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'page' => $page
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
     * 获取多条
     * @return mixed
     */
    public function getItems()
    {
        $ids = $this->input->getString('ids');
        if (empty($ids)) {
            return $this->export([
                'code' => $this->code('INVALID_ID'),
                'message' => 'ID无效'
            ]);
        }
        $ids = explode(',', $ids);
        $pageModel = new PageModel();
        try {
            $page = $pageModel->getItems([
                'ids' => $ids
            ]);
            return $this->export([
                'data' => [
                    'page' => $page
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
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $statuses = $this->input->getString('statuses');
        $publishedOnly = $this->input->getInt('published_only', 1);
        $pageModel = new PageModel();
        if (!empty($statuses)) {
            $statuses = explode(',', $statuses);
        }
        if ($publishedOnly && empty($statuses)) {
            $statuses = [2];
        }
        $params = [
            'keywords' => $this->input->getString('keywords', ''),
            'title' => $this->input->getString('title', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'statuses' => $statuses,
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $pageModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}