<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/10
 * Time: 下午10:58
 */

namespace Module\Supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 投诉管理
 * Class Complaint
 * @package Module\Supervisor\Controller
 */
class Complaint extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'supervisor/complaint/index';
        $this->view->priority = [
            '1' => '',
            '2' => '',
            '3' => ''
        ];
        $this->view->statuses = [
            '1' => '',
            '2' => ''
        ];
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_COMPLAINT_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('supervisor/ProductComplaint/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('supervisor/complaint/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('supervisor/complaint/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('supervisor/ProductComplaint/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('supervisor/complaint/index'));
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
            $response = $this->api->call('supervisor/ProductComplaint/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->department;
            $this->view->render('supervisor/complaint/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('supervisor/ProductComplaint/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'supervisor/complaint/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}