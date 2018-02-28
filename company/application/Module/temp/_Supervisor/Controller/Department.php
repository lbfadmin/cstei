<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-23
 * Time: 上午10:40
 */

namespace Module\supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 部门管理
 * Class Department
 * @package Module\supervisor\Controller
 */
class Department extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'supervisor/department/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_DEPARTMENT_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('supervisor/department/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('supervisor/department/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('supervisor/department/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('supervisor/department/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('supervisor/department/index'));
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
            $response = $this->api->call('supervisor/department/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->department;
            $this->view->render('supervisor/department/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('supervisor/department/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'supervisor/department/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}