<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Company\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理设备类型
 * Class Power
 * @package Module\Company\Controller
 */
class DeviceType extends Auth
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
        $response = $this->api->call('producer/device-type/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('company/devicetype/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('company/devicetype/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('producer/device-type/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('company/device-type/index'));
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
            $response = $this->api->call('producer/device-type/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->devicetype;
            $this->view->render('company/devicetype/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('producer/device-type/update', $data);
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