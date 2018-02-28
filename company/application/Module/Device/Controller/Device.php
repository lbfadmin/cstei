<?php
/**
 * Created by PhpStorm.
 * User: yueliang
 * Date: 2018/1/19
 * Time: 下午7:28
 */

namespace Module\Device\Controller;

use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 设备管理
 * Class device
 * @package Module\Device\Controller\Device
 */
class Device extends Auth
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
        //获取设备类型
        $responsedevice= $this->api->call('producer/device-type/get-list');
        $devices=$responsedevice->data->list;

        $response = $this->api->call('producer/device/get-list', $params);
        foreach($response->data->list as $k=>$v){

            foreach($devices as $kk=>$vv)
            {
                if($vv->id==$v->device_type){
                    $response->data->list[$k]->devicetype_name = $devices[$kk]->type_name;
                }
            }
        }
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);

        $this->view->render('producer/device/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            //获取设备类型
            $response = $this->api->call('producer/device-type/get-list');
            $list_array = array();
            foreach($response->data->list as $k=>$v){
                $list_array[$v->id] = $v->type_name;
            }
            $this->view->devices = $list_array;

            $this->view->render('producer/device/form');
        } else {

            $data = $this->input->getArray();
            $data['pic'] = $this->uploadImage();//上传缩略图
            $response = $this->api->call('producer/device/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/device/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }
    /**
     * 查看
     */
    public function check()
    {
        //获取设备类型
        $response = $this->api->call('producer/device-type/get-list');
        $list_array = array();
        foreach($response->data->list as $k=>$v){
            $list_array[$v->id] = $v->type_name;
        }
        $this->view->devices = $list_array;

        $response = $this->api->call('producer/device/get-item', [
            'id' => $this->input->getInt('id')
        ]);

        $this->view->item = $response->data->device;
        $this->view->render('producer/device/check');
    }
    /**
     * 编辑
     */
    public function edit()
    {
        if (empty($_POST)) {
            //获取设备类型
            $response = $this->api->call('devcie/device-type/get-list');
            $list_array = array();
            foreach($response->data->list as $k=>$v){
                $list_array[$v->id] = $v->type_name;
            }
            $this->view->devices = $list_array;

            $response = $this->api->call('device/device/get-item', [
                'id' => $this->input->getInt('id')
            ]);

            $this->view->item = $response->data->device;
            $this->view->render('producer/device/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $data['pic'] = $this->uploadImage();//上传缩略图
            $response = $this->api->call('producer/device/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/device/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }


    //获取文件后缀名函数
    function fileext($filename)
    {
        return substr(strrchr($filename, '.'), 1);
    }

    //生成随机文件名函数
    function random($length)
    {
        $hash = 'CR-';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($chars) - 1;
        mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    function uploadImage(){
        /*允许缩略图为空*/
        if (empty($_FILES['pic']) || $_FILES['pic']['error']) {
            // $this->message->set('未选择缩略图', 'error');
            // $this->response->refresh();
        }else{

            $uploaddir = dirname(ROOT)."/files/";//设置文件保存目录 注意包含/
            // echo $uploaddir;
            // exit;
            $type=array("jpg","gif","bmp","jpeg","png");//设置允许上传文件的类型


            $a=strtolower($this->fileext($_FILES['pic']['name']));

            //判断文件类型
            if(!in_array(strtolower($this->fileext($_FILES['pic']['name'])),$type))
            {
                $text=implode(",",$type);
                echo "您只能上传以下类型文件: ",$text,"<br>";
            }
            //生成目标文件的文件名
            else{
                $filename=explode(".",$_FILES['pic']['name']);
                do
                {
                    $filename[0]=$this->random(10); //设置随机数长度
                    $name=implode(".",$filename);
                    //$name1=$name.".Mcncc";
                    $uploadfile=$uploaddir.$name;
                }
                while(file_exists($uploadfile));
                 print_r($uploadfile);
                if (move_uploaded_file($_FILES['pic']['tmp_name'],$uploadfile)){
                    $data['pic'] = $name;

                }
            }
        }
        return $name;
    }


}