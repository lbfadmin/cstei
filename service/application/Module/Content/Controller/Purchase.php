<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-20
 * Time: 上午10:46
 */

namespace Module\Content\Controller;


use Application\Controller\Api;
use Module\Content\Model\PurchaseModel;
use System\Component\Validator\Validator;

/**
 * 商品订单
 * Class Purchase
 * @package Module\Content\Controller
 */
class Purchase extends Api
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
        $purchaseModel = new PurchaseModel();
        $data['time_created'] =
        $data['time_updated'] = date('Y-m-d H:i:s');
        unset($data['id']);
        $this->prepareData($data);
        if (empty($data['time_evaluated'])) {
            $data['time_evaluated'] = $data['time_created'];
        }
        try {

            $id = $purchaseModel->add($data);

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
        $purchaseModel = new PurchaseModel();
        $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            if (empty($data['picture'])) {
                unset($data['picture']);
            }
            $this->prepareData($data);
            $result = $purchaseModel->update($data, ['id=?', [$data['id']]]);

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
        $this->preProcessData($data, PurchaseModel::$fields);
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
        if (isset($data['goods_id']) || $create) {
            $fields[] = [
                'name' => '商品id',
                'value' => value($data, 'goods_id'),
                'rules' => [
                    'required' => ['code' => 'GOODS_ID_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['batch_sn']) || $create) {
            $fields[] = [
                'name' => '商品批次号',
                'value' => value($data, 'batch_sn'),
                'rules' => [
                    'required' => ['code' => 'BATCH_SN_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['sn']) || $create) {
            $fields[] = [
                'name' => '订单编号',
                'value' => value($data, 'sn'),
                'rules' => [
                    'required' => ['code' => 'SN_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['quantity']) || $create) {
            $fields[] = [
                'name' => '购买数量',
                'value' => value($data, 'quantity'),
                'rules' => [
                    'required' => ['code' => 'QUANTITY_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['unit_price']) || $create) {
            $fields[] = [
                'name' => '单价',
                'value' => value($data, 'unit_price'),
                'rules' => [
                    'required' => ['code' => 'UNIT_PRICE_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['customer_name']) || $create) {
            $fields[] = [
                'name' => '客户名称',
                'value' => value($data, 'customer_name'),
                'rules' => [
                    'required' => ['code' => 'CUSTOMER_NAME_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['customer_address']) || $create) {
            $fields[] = [
                'name' => '客户地址',
                'value' => value($data, 'customer_address'),
                'rules' => [
                    'required' => ['code' => 'CUSTOMER_ADDRESS_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['customer_contact']) || $create) {
            $fields[] = [
                'name' => '下单人',
                'value' => value($data, 'customer_contact'),
                'rules' => [
                    'required' => ['code' => 'CUSTOMER_CONTACT_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['customer_tel']) || $create) {
            $fields[] = [
                'name' => '下单人',
                'value' => value($data, 'customer_tel'),
                'rules' => [
                    'required' => ['code' => 'CUSTOMER_TEL_IS_REQUIRED']
                ]
            ];
        }
        if (isset($data['rank']) || $create) {
            $fields[] = [
                'name' => '评分',
                'value' => value($data, 'rank'),
                'rules' => [
                    'required' => ['code' => 'RANK_IS_REQUIRED']
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
        $purchaseModel = new PurchaseModel();
        try {
            $result = $purchaseModel->delete(['id=?', [$id]]);

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
        $purchaseModel = new PurchaseModel();
        try {
            $item = $purchaseModel->getItem([
                'id' => $id
            ]);
            return $this->export([
                'data' => [
                    'purchase' => $item
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
        $purchaseModel = new PurchaseModel();
        $params = [
            'goods_id' => $this->input->getString('goods_id', ''),
            'created_start' => $this->input->getString('created_start'),
            'created_end' => $this->input->getString('created_end'),
            'sn' => $this->input->getString('sn'),
            'batch_sn' => $this->input->getString('batch_sn'),
            'page' => $page,
            'limit' => $limit = $this->input->getInt('limit', 20)
        ];
        $result = $purchaseModel->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
}