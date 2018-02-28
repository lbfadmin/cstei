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
 * 设备管理
 * Class device
 * @package Module\Producer\Controller\Device
 */
class DeviceProduction extends Auth
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
        $response = $this->api->call('device/device/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        //print_r($response->data);
        //exit;
        // var_dump($response->data);
        $this->view->render('company/device/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('company/device/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('device/device/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('company/device/index'));
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
            $response = $this->api->call('company/device/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->production_unit;
            $this->view->render('company/device/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('device/device/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'compnay/device/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}