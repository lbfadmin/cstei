<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-6-23
 * Time: 下午1:30
 */

namespace Module\Content\Controller;


use Application\Component\Io\QiniuStorage;
use Application\Controller\Api;
use Application\Component\Util\File;
use Module\Account\Model\UserModel;
use Module\Content\IndexModel\InfoIndexModel;
use Module\Content\Model\InfoGalleryModel;
use Module\Content\Model\InfoModel;
use System\Component\Validator\Validator;

/**
 * 资讯操作
 * Class Info
 * @package Module\Content\Controller
 */
class Info extends Api
{


    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 0);
        $page = $page > 0 ? $page : 0;

        $statuses = $this->input->getString('statuses');
        $publishedOnly = $this->input->getInt('published_only', 1);
        $infoModel = new InfoModel();
        if (!empty($statuses)) {
            $statuses = explode(',', $statuses);
        }
        if ($publishedOnly && empty($statuses)) {
            $statuses = [2];
        }
        $params = [
            'keywords' => $this->input->getString('keywords', ''),
            'category_id' => $this->input->getString('category_id', '0'),
			'parentId' => $this->input->getString('parentId', '0'),
            'title' => $this->input->getString('title', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'statuses' => $statuses,           
			'pager' => [
                'page' => $page,
                'limit' => $limit = $this->input->getInt('limit', 20)
            ]
            // 'page' => $page,
            // 'limit' => $limit = $this->input->getInt('limit', 20)
        ];
	
        $result = $infoModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
	
    /**
     * 添加
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
        $infoModel = new InfoModel();
        try {
            if (!isset($data['uid'])) {
                $data['uid'] = 0;
            }

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
            $id = $infoModel->add($data);

            // 索引
            // try {
                // $data['id'] = $id;
                // $this->preProcessData($data, InfoIndexModel::$fields);
                // $indexModel = new InfoIndexModel();
                // $indexModel->index($data);
            // } catch (\Exception $e) {
                // return $this->export([
                    // 'code' => self::STATUS_SYS_ERROR,
                    // 'message' => $e->getMessage()
                // ]);
            // }

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
        $infoModel = new InfoModel();
        $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            if (empty($data['picture'])) {
                unset($data['picture']);
            }
            $this->prepareData($data);
            $result = $infoModel->update($data, ['id=?', [$data['id']]]);

            // 索引
            try {
                $this->preProcessData($data, InfoIndexModel::$fields);
                $indexModel = new InfoIndexModel();
                $indexModel->update($data['id'], $data);
            } catch (\Exception $e) {

            }

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
        $this->preProcessData($data, InfoModel::$fields);
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
                            'match' => isset(InfoModel::$statuses[$field['value']]),
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
        // if ($create) {
            // $fields[] = [
                // 'name' => '缩略图',
                // 'value' => value($data, 'picture'),
                // 'rules' => [
                    // 'required' => ['code' => 'PICTURE_IS_REQUIRED']
                // ]
            // ];
        // }
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
            $data['status'] = InfoModel::$statuses[$data['status']];
        }
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $infoModel = new InfoModel();
        try {
            $result = $infoModel->delete(['id=?', [$id]]);
            if ($result) {
                // 删除索引
                try {
                    $indexModel = new InfoIndexModel();
                    $indexModel->delete($id);
                } catch (\Exception $e) {

                }
            }

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
        $infoModel = new InfoModel();
        try {
            $info = $infoModel->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'info' => $info
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
        $infoModel = new InfoModel();
        try {
            $info = $infoModel->getItems([
                'ids' => $ids
            ]);
            return $this->export([
                'data' => [
                    'info' => $info
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
    public function getAll()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $statuses = $this->input->getString('statuses');
        $publishedOnly = $this->input->getInt('published_only', 1);
        $infoModel = new InfoModel();
        if (!empty($statuses)) {
            $statuses = explode(',', $statuses);
        }
        if ($publishedOnly && empty($statuses)) {
            $statuses = [2];
        }
        $params = [
            'keywords' => $this->input->getString('keywords', ''),
            'category_id' => $this->input->getString('category_id', '0'),
			'parentId' => $this->input->getString('parentId', '0'),
            'title' => $this->input->getString('title', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'statuses' => $statuses,
            'page' => $page,
            // 'limit' => $limit = $this->input->getInt('limit', 20)
        ];
		// print_r($params);
		// exit;
        $result = $infoModel->getAll($params);
		// exit;
        return $this->export([
            'data' => $result
        ]);
    }
    /**
     * 搜索
     * @return mixed
     */
    public function search()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $excludes = $this->input->getString('excludes');
        $statuses = $this->input->getString('statuses');
        $publishedOnly = $this->input->getInt('published_only', 1);
        $sort = $this->input->getString('sort', 'published_desc');
        $infoModel = new InfoModel();
        $indexModel = new InfoIndexModel();
        if (!empty($excludes)) {
            $excludes = explode(',', $excludes);
        }
        if (!empty($statuses)) {
            $statuses = explode(',', $statuses);
        }
        if ($publishedOnly && empty($statuses)) {
            $statuses = [2];
        }
        $params = [
            'category_id' => $this->input->getInt('category_id', null),
            'keywords' => $this->input->getString('keywords', ''),
            'title' => $this->input->getString('title', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'excludes' => $excludes,
            'statuses' => $statuses,
            'published_only' => $publishedOnly,
            'sort' => InfoIndexModel::$sortTypes[$sort],
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        // $result = $indexModel->search($params);
        // $list = [];
        // if (!empty($result['hits']['hits'])) {
            // $ids = [];
            // foreach ($result['hits']['hits'] as $hit) {
                // $ids[$hit['_id']] = $hit['_id'];
            // }
            $items = $infoModel->getItems([
                // 'ids' => array_filter($ids),
                // 'fields' => implode(',', array_diff(InfoModel::$fields, ['body']))
            ]);
            // foreach ($result['hits']['hits'] as $hit) {
                // $list[] = &$items[$hit['_id']];
            // }
        // }
        $data = [
            // 'total' => $result['hits']['total'],
            'list' => $list
        ];
        return $this->export([
            'data' => $data
        ]);
    }
}