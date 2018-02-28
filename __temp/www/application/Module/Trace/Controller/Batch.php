<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-2-16
 * Time: 上午10:34
 */

namespace Module\Trace\Controller;


use Application\Component\Util\ApiRequest;
use Application\Controller\Front;

/**
 * 批次追溯
 * Class Batch
 * @package Module\Trace\Controller
 */
class Batch extends Front
{

    /**
     * 追溯详情
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $sn = $name;
        $this->view->batch_sn = $sn;
        $response = $this->api->call('project/batch/get-item', [
            'sn' => $sn
        ]);
        $batch = $response->data->item;
        $this->view->batch = $batch;
        if (empty($batch)) {
            goto VIEW;
        }
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
        ];
        $this->api->callMultiple($requests);

        VIEW:
        $this->view->render('trace/batch/view');
    }

    /**
     * 搜索批次
     */
    public function search()
    {
         $sn = $this->input->getString('sn');
        $this->view->batch_sn = $sn;
        $response = $this->api->call('project/batch/get-item', [
            'sn' => $sn
        ]);
        $batch = $response->data->item;
        $this->view->batch = $batch;
        $this->view->render('trace/batch/search');
    }
}