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
use Module\Content\IndexModel\ShoppingPlatformIndexModel;
use Module\Content\Model\ShoppingPlatformGalleryModel;
use Module\Content\Model\ShoppingPlatformModel;
use System\Component\Validator\Validator;

/**
 * Class ShoppingPlatform
 * @package Module\Content\Controller
 */
class ShoppingPlatform extends Api
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
        $shoppingPlatformModel = new ShoppingPlatformModel();
        try {

            $data['time_created'] =
            $data['time_updated'] = date('Y-m-d H:i:s');
            unset($data['id']);
            $this->prepareData($data);
            $id = $shoppingPlatformModel->add($data);

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
        $shoppingPlatformModel = new ShoppingPlatformModel();
        $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            if (empty($data['picture'])) {
                unset($data['picture']);
            }
            $this->prepareData($data);
            $result = $shoppingPlatformModel->update($data, ['id=?', [$data['id']]]);

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
        $this->preProcessData($data, ShoppingPlatformModel::$fields);
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
        if (isset($data['name']) || $create) {
            $fields[] = [
                'name' => '名称',
                'value' => value($data, 'name'),
                'rules' => [
                    'required' => ['code' => 'TITLE_IS_REQUIRED']
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
        }
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
        $shoppingPlatformModel = new ShoppingPlatformModel();
        try {
            $result = $shoppingPlatformModel->delete(['id=?', [$id]]);

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
        $shoppingPlatformModel = new ShoppingPlatformModel();
        try {
            $shoppingPlatform = $shoppingPlatformModel->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'shoppingPlatform' => $shoppingPlatform
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
        $shoppingPlatformModel = new ShoppingPlatformModel();
        try {
            $shoppingPlatform = $shoppingPlatformModel->getItems([
                'ids' => $ids
            ]);
            return $this->export([
                'data' => [
                    'shoppingPlatform' => $shoppingPlatform
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
     * 获取全部
     * @return mixed
     */
    public function getAll()
    {
        $shoppingPlatformModel = new ShoppingPlatformModel();
        try {
            $result = $shoppingPlatformModel->getAll([
                'fields' => $_REQUEST['fields'] ?: '*'
            ]);
            return $this->export([
                'data' => [
                    'platforms' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'data' => [
                    'platforms' => []
                ]
            ]);
        }
    }
}