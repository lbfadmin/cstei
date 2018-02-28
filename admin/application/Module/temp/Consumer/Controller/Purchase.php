<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-19
 * Time: 下午1:23
 */

namespace Module\Consumer\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * Class Purchase
 * @package Module\Consumer\Controller
 */
class Purchase extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_PURCHASE_MANAGE'
        ];
    }

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'consumer/purchase/index';
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $params['published_only'] = 0;
        if (!empty($params['created_start'])) {
            $params['created_start'] = $params['created_start'] . ' 00:00:00';
        }
        if (!empty($params['created_end'])) {
            $params['created_end'] = $params['created_end'] . ' 00:00:00';
        }
        $response = $this->api->call('content/purchase/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('consumer/purchase/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $response = $this->api->call('content/shopping-platform/get-all');
            $this->view->platforms = $response->data->platforms;
            $this->view->render('consumer/purchase/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('content/purchase/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('consumer/purchase/index'));
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
            $response = $this->api->call('content/purchase/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->purchase;
            $response = $this->api->call('content/shopping-platform/get-all');
            $this->view->platforms = $response->data->platforms;
            $this->view->render('consumer/purchase/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('content/purchase/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'consumer/purchase/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}