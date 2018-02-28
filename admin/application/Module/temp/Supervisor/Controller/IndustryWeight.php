<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:18
 */

namespace Module\Supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 行业分布
 * Class IndustryWeight
 * @package Module\Supervisor\Controller
 */
class IndustryWeight extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'supervisor/industry-weight/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_INDUSTRY_WEIGHT_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $response = $this->api->call('project/SupervisorIndustryWeight/get-tree', $params);
        $this->view->industrys = $response->data->children;
        $this->view->render('supervisor/industry-weight/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('supervisor/industry-weight/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/SupervisorIndustryWeight/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('supervisor/industry-weight/index'));
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
            $response = $this->api->call('project/SupervisorIndustryWeight/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('supervisor/industry-weight/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/SupervisorIndustryWeight/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'supervisor/industry-weight/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}