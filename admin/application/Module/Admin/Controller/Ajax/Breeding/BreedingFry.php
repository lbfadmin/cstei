<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 上午11:19
 */

namespace Module\Producer\Controller\Ajax\Breeding;


use Module\Account\Controller\Ajax;

/**
 * 养殖产量统计
 * Class Power
 * @package Module\Producer\Controller\Ajax\Device
 */
class BreedingFry extends Ajax
{
    /**
     * 删除
     */
    public function delete()
    {
		$id = $_REQUEST['id'];
		//取得该数据对应的示范县区编号、季度、养殖方式
		$response = $this->api->call('/producer/breeding-fry/get-item', [
            'id' => $_REQUEST['id']
            
        ]);
		$data = (array)$response->data->production_unit;

		$params =array();
		$params['unit_id'] = $data['unit_id'];
		$params['quarter'] = $data['quarter'];
		
		// print_r($params);
		// exit;
        $response = $this->api->call('producer/breeding-fry/delete', $params);
	
        $this->export($response);
    }
    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_DEVICE_POWER_MANAGE'
        ];
    }

    /**
     * 添加
    public function create()
    {
        $data = $_POST;
        $data['production_unit_id'] = 1;
        $response = $this->api->call('project/device-power/create', $data);
        $this->export($response);
    }
     */


    /**
     * 更新
     */
/*
    public function update()
    {
        $response = $this->api->call('project/device-power/update', $_POST);
        $this->export($response);
    }
*/


}