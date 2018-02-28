<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-27
 * Time: 下午4:33
 */

namespace Module\Farming\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 养殖池管理ajax
 * Class Pool
 * @package Module\Farming\Controller\Ajax
 */
class Pool extends Ajax
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
     * 添加
     */
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = $this->company->id;
        $response = $this->api->call('project/production-pool/create', $data);
        $this->export($response);
    }

    /**
     * 更新
     */
    public function update()
    {
        $response = $this->api->call('project/production-pool/update', $_POST);
        $this->export($response);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $response = $this->api->call('project/production-pool/delete', [
            'id' => $_REQUEST['id']
        ]);
        $this->export($response);
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $response = $this->api->call('project/production-pool/get-all', $_GET);
        $list = &$response->data->list;
        if ($list) {
            $poolIds = [];
            foreach ($list as $item) {
                $poolIds[$item->id] = $item->id;
            }
            $response2 = $this->api->call('project/production-env/get-pools-latest', [
                'pool_ids' => implode(',', $poolIds)
            ]);
            $env = $response2->data->list;
            foreach ($list as &$item) {
                $item->temperature = $env->{$item->id}->temperature;
                $item->oxy = $env->{$item->id}->oxy;
            }
        }
        $this->export($response);
    }
}