<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\Device;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理设备开关机记录
 * Class Power
 * @package Module\Producer\Controller\Device
 */
class Power extends Auth
{

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
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
		if (!empty($_POST)) {
			$data = $this->input->getArray();
			// print_r($data["id"]);
			// exit;
			//保存上传的数据 ，空默认为0
			$data['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			$data['time_updated'] = date('Y-m-d H:i:s');	//创建时间

			if(!$data["id"]){
				unset($data['id']);
				// echo "create";
				// exit;
				$response = $this->api->call('producer/breeding-area/create', $data);
				if ($response->code === 'OK') {
					$this->message->set('添加成功', 'success');
					$this->response->redirect(url('/producer/device/power/index'));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}
			}else{

				// echo "update";
				// exit;
				$response = $this->api->call('producer/breeding-area/update', $data);
				if ($response->code === 'OK') {
					$this->message->set('修改成功', 'success');
					$this->response->redirect(url('/producer/device/power/index'));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}

			}

		}
		
        //获取设备
		// $params['unit_id'] = $_SESSION['user']->unit_id;//
        $response = $this->api->call('producer/breeding-area/get-list', $params);
        $this->view->result = $response->data;
// print_r($response);
// exit;
        $this->view->render('producer/device/power/index');
    }
}