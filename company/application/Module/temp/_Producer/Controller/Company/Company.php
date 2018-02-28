<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-16
 * Time: 上午11:31
 */

namespace Module\Producer\Controller\Company;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理企业信息
 * Class Company
 * @package Module\Producer\Controller\Company
 */
class Company extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'producer/company/company/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_COMPANY_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-unit/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('producer/company/company/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('producer/company/company/form');
        } else {
            $data = $this->input->getArray();
            // if (empty($_FILES['logo']) || $_FILES['logo']['error']) {
                // $this->message->set('未选择LOGO', 'error');
                // $this->response->refresh();
            // }
            // $file['logo'] = new \CURLFile($_FILES['logo']['tmp_name'], null, 'logo');
            // $response = $this->api->call('common/image/upload', $file);
            // $data['logo'] = $response->data->key;
            $response = $this->api->call('project/production-unit/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/company/company/index'));
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
            $response = $this->api->call('project/production-unit/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->production_unit;
            $this->view->render('producer/company/company/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/production-unit/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/company/company/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}