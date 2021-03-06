<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Device\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 设备申请使用
 * Class Power
 * @package Module\Device\Controller\Device;
 */
class DeviceUse extends Auth
{

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 10;

        if (isset($params['page'])) {
            $params['page'] += 1;
        }
        //获取公司id
        $company_id=$_SESSION['user']->unit_id;
        $params['company_id']=11;
        $status=array(0=>"申请",1=>"通过",2=>"拒绝",3=>"使用",4=>"归还",5=>"完成");
        $this->view->status=$status;

        //设备
        $responsed = $this->api->call('producer/device/get-list');;
        $list_array = array();
        foreach($responsed->data->list as $k=>$v){
            $list_array[$v->id] = $v->device_name;
        }
        $this->view->device=$list_array;
        //获取申请列表
        $response = $this->api->call('producer/device-use/get-company-list', $params);

        //获取公司名称和设备名称
        foreach($response->data->list as $k=>$v){

            $companyresponse=$this->api->call('producer/company/get-item',[
                'id' => $v->company_id
            ]);
            $response->data->list[$k]->company_name = $companyresponse->data->production_unit->name;
            $deviceresponse=$this->api->call('producer/device/get-item',[
                'id' => $v->device_id
            ]);
            $response->data->list[$k]->device_name = $deviceresponse->data->device->device_name;

        }

        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);

        $this->view->render('producer/deviceuse/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $deviceId = $this->input->getInt("deviceId");
            //获取设备信息
            $device=$this->api->call('producer/device/get-item',['id'=>$deviceId]);
            //获取设备类型
            $deviceType=$this->api->call('producer/device-type/get-item',['id'=>$device->data->device->device_type]);
            $this->view->device=$device->data->device;
            $this->view->devicetype=$deviceType->data->devicetype;
            $this->view->render('producer/deviceuse/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('producer/device-use/create', $data);

            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('device/device-use/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (empty($_POST)) {
            $response = $this->api->call('producer/device-use/get-item', [
                'id' => $this->input->getInt('id')
            ]);

            $this->view->item = $response->data->deviceuse;
            $this->view->render('producer/deviceuse/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('producer/device-use/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/device-use/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}