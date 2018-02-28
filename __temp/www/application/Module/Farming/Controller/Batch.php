<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-28
 * Time: 下午12:16
 */

namespace Module\Farming\Controller;


use Application\Component\Util\ApiRequest;
use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 批次管理
 * Class Batch
 * @package Module\Farming\Controller
 */
class Batch extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_BATCH_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/product-type/get-all');
        $this->view->product_types = $response->data->list;
        $response = $this->api->call('project/batch/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $response = $this->api->call('project/production-pool/get-all');
        $this->view->pools = $response->data->list;
        $this->view->render('farming/batch/index');
    }

    /**
     * 追溯
     */
    public function trace()
    {
        $sn = $this->input->getString('sn');
        $this->view->batch_sn = $sn;
        $response = $this->api->call('project/batch/get-item', [
            'sn' => $sn
        ]);
        $batch = $response->data->item;
        $this->view->batch = $batch;
        $requests = [
            // 生产单位
            new ApiRequest(
                'project/production-unit/get-item',
                [
                    'id' => $batch->production_unit_id
                ],
                function ($response) {
                    $this->view->manufacture = $response->data->production_unit;
                }
            ),
            // 企业诚信
            new ApiRequest(
                'project/production-unit-credit/get-item',
                [
                    'unit_id' => $batch->production_unit_id
                ],
                function ($response) {
                    $this->view->credit = $response->data->item;
                }
            ),
            // 销售记录
            new ApiRequest(
                'content/purchase/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->sales_list = $response->data->list;
                }
            ),
            // 物流记录
            new ApiRequest(
                'project/logistics-transport/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->transport_list = $response->data->list;
                }
            ),
            // 加工记录
            new ApiRequest(
                'project/production-processing/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->processing_list = $response->data->list;
                }
            ),
            // 饲养记录
            new ApiRequest(
                'producer/feed-use/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->feed_list = $response->data->list;
                }
            ),
            // 抽检记录
            new ApiRequest(
                'project/spot-check/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->check_list = $response->data->list;
                }
            ),
            // 入库记录
            new ApiRequest(
                'project/warehousing/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->warehousing_list = $response->data->list;
                }
            ),
            // 出库记录
            new ApiRequest(
                'project/ex-ware-house/get-list',
                [
                    'batch_sn' => $sn,
                    'limit' => 10
                ],
                function ($response) {
                    $this->view->ex_warehouse_list = $response->data->list;
                }
            ),
        ];
        $this->api->callMultiple($requests);
        $this->view->activePath = 'farming/batch/index';
        $this->view->render('farming/batch/trace');
    }
}