<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-23
 * Time: 下午3:09
 */

namespace Module\Supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 专家诊断
 * Class SpotCheck
 * @package Module\Supervisor\Controller
 */
class SpotCheck extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'supervisor/spot-check/index';
        $this->view->unqualifiedTypes = [
            '1' => '药物超标',
            '2' => '细菌超标',
            '3' => '腐坏变质'
        ];
        $this->view->progresses = [
            '1' => '处理中',
            '2' => '已处罚'
        ];
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_SPOT_CHECK_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('supervisor/spot-check/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('supervisor/spot-check/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('supervisor/spot-check/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('supervisor/spot-check/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('supervisor/spot-check/index'));
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
            $response = $this->api->call('supervisor/spot-check/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->check;
            $this->view->render('supervisor/spot-check/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('supervisor/spot-check/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'supervisor/spot-check/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}