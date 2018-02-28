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
use Module\Content\IndexModel\GoodsIndexModel;
use Module\Content\Model\GoodsGalleryModel;
use Module\Content\Model\GoodsModel;
use System\Component\Validator\Validator;

/**
 * 商品操作
 * Class Goods
 * @package Module\Content\Controller
 */
class Goods extends Api
{

    /**
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
        $error = $this->validate($data);
        if ($error) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $goodsModel = new GoodsModel();
        try {

            $data['time_created'] =
            $data['time_updated'] = date('Y-m-d H:i:s');
            unset($data['id']);
            $this->prepareData($data);
            $id = $goodsModel->add($data);

            // 索引
            try {
                $data['id'] = $id;
                $this->preProcessData($data, GoodsIndexModel::$fields);
                $indexModel = new GoodsIndexModel();
                $indexModel->index($data);
            } catch (\Exception $e) {
                return $this->export([
                    'code' => self::STATUS_SYS_ERROR,
                    'message' => $e->getMessage()
                ]);
            }

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
        $goodsModel = new GoodsModel();
        $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            if (empty($data['picture'])) {
                unset($data['picture']);
            }
            $this->prepareData($data);
            $result = $goodsModel->update($data, ['id=?', [$data['id']]]);

            // 索引
            try {
                $this->preProcessData($data, GoodsIndexModel::$fields);
                $indexModel = new GoodsIndexModel();
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
        $this->preProcessData($data, GoodsModel::$fields);
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
                    'required' => ['code' => 'CATEGORY_IS_REQUIRED'],
                    'int' => ['code' => 'CATEGORY_ID_MUST_BE_INT']
                ]
            ];
        }
        if (isset($data['name']) || $create) {
            $fields[] = [
                'name' => '名称',
                'value' => value($data, 'name'),
                'rules' => [
                    'required' => ['code' => 'NAME_IS_REQUIRED']
                ]
            ];
        }
        if ($create) {
            $fields[] = [
                'name' => '缩略图',
                'value' => value($data, 'picture'),
                'rules' => [
                    'required' => ['code' => 'PICTURE_IS_REQUIRED']
                ]
            ];
            $fields[] = [
                'name' => '规格',
                'value' => value($data, 'spec'),
                'rules' => [
                    'required' => ['code' => 'SPEC_IS_REQUIRED']
                ]
            ];
            $fields[] = [
                'name' => '数量',
                'value' => value($data, 'quantity'),
                'rules' => [
                    'required' => ['code' => 'QUANTITY_IS_REQUIRED']
                ]
            ];
            $fields[] = [
                'name' => '价格',
                'value' => value($data, 'price'),
                'rules' => [
                    'required' => ['code' => 'PRICE_IS_REQUIRED']
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
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $id = $this->input->getInt('id');
        $goodsModel = new GoodsModel();
        try {
            $result = $goodsModel->delete(['id=?', [$id]]);
            if ($result) {
                // 删除索引
                try {
                    $indexModel = new GoodsIndexModel();
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
        $goodsModel = new GoodsModel();
        try {
            $goods = $goodsModel->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'goods' => $goods
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
        $goodsModel = new GoodsModel();
        try {
            $goods = $goodsModel->getItems([
                'ids' => $ids
            ]);
            return $this->export([
                'data' => [
                    'goods' => $goods
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
     * 搜索
     * @return mixed
     */
    public function search()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $excludes = $this->input->getString('excludes');
        $sort = $this->input->getString('sort', 'published_desc');
        $goodsModel = new GoodsModel();
        $indexModel = new GoodsIndexModel();
        if (!empty($excludes)) {
            $excludes = explode(',', $excludes);
        }
        $params = [
            'category_id' => $this->input->getInt('category_id', null),
            'id' => $this->input->getInt('id', null),
            'keywords' => $this->input->getString('keywords', ''),
            'name' => $this->input->getString('name', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'excludes' => $excludes,
            'sort' => GoodsIndexModel::$sortTypes[$sort],
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $indexModel->search($params);
        $list = [];
        if (!empty($result['hits']['hits'])) {
            $ids = [];
            foreach ($result['hits']['hits'] as $hit) {
                $ids[$hit['_id']] = $hit['_id'];
            }
            $items = $goodsModel->getItems([
                'ids' => array_filter($ids),
                'fields' => implode(',', GoodsModel::$fields)
            ]);
            foreach ($result['hits']['hits'] as $hit) {
                $list[] = &$items[$hit['_id']];
            }
        }
        $data = [
            'total' => $result['hits']['total'],
            'list' => $list
        ];
        return $this->export([
            'data' => $data
        ]);
    }
}