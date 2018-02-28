<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午3:31
 */

namespace Module\Trace\Controller;


use Application\Component\Util\ApiRequest;
use Application\Controller\Front;

/**
 * 试验站
 * Class Pool
 * @package Module\Trace\Controller
 */
class TestStation extends Front
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_POOL_MANAGE'
        ];
    }


    /**
     * 试验站
     */
    public function index()
    {

        // $poolId = $this->input->getInt('id');
        ////池子信息
        // $response = $this->api->call('project/production-pool/get-item', [
            // 'id' => $poolId
        // ]);
        // $this->view->pool = $response->data->item;
        // $this->view->activePath = 'trace/market/index';
        $this->view->render('trace/teststation');
/**/
    }
    /**
     * 试验站
     */
    public function getlist()
    {

        //$poolId = $this->input->getInt('id');
        // 池子信息
        $response = $this->api->call('project/production-pool/get-item', [
            'id' => $poolId
        ]);
        $this->view->pool = $response->data->item;
        $this->view->activePath = 'trace/market/index';
        $this->view->render('trace/market/charts');
/**/
    }
    /**
     * 列表
   public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/product-type/get-all');
        $this->view->product_types = $response->data->list;
        $response = $this->api->call('project/production-pool/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->statuses = [
            '1' => '正常',
            '2' => '检查维修',
            '3' => '异常'
        ];
        $params['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-pool-category/get-tree', $params);
        $this->view->categories = $response->data->children;
        $this->view->render('farming/pool/index');
    }
     */
 

    /**
     * 详情
    public function view()
    {
        $poolId = $this->input->getInt('id');
        // 相关设备
        $requests = [
            // 养殖池
            new ApiRequest(
                'project/production-pool/get-item',
                [
                    'id' => $poolId
                ],
                function ($response) {
                    $this->view->pool = $response->data->item;
                }
            ),

            // 环境信息
            new ApiRequest(
                'project/production-env/get-pools-latest',
                [
                    'pool_ids' => $poolId
                ],
                function ($response) {
                    $env = $response->data->list ? current($response->data->list) : (object)[];
                    $this->view->env = $env;
                }
            ),

            // 批次信息
            new ApiRequest(
                'project/batch-pool/get-batches-by-pool',
                [
                    'pool_id' => $poolId
                ],
                function ($response) {
                    $this->view->related_batches = $response->data->items;
                }
            ),

            // 设备信息
            new ApiRequest(
                'project/device/get-list',
                [
                    'container_type' => 'POOL',
                    'container_id' => $poolId
                ],
                function ($response) {
                    $devices = $response->data->list;
                    $this->view->related_devices = $response->data->list;
                    if (!empty($devices)) {
                        $typeIds = [];
                        foreach ($devices as $device) {
                            $typeIds[$device->type_id] = $device->type_id;
                        }
                        $response = $this->api->call('project/device-type/get-items', [
                            'ids' => implode(',', $typeIds)
                        ]);
                        foreach ($devices as $device) {
                            $device->type = $response->data->items->{$device->type_id};
                        }
                    }
                }
            ),
        ];
        $this->api->callMultiple($requests);
        $this->view->activePath = 'farming/pool/index';
        $this->view->render('farming/pool/view');
    }

     */

}