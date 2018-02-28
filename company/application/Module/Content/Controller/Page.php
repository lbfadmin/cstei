<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 上午11:35
 */

namespace Module\Content\Controller;


use Module\Account\Controller\Auth;

/**
 * 管理页面
 * Class Page
 * @package Module\Content\Controller
 */
class Page extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'content/page/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONTENT_PAGE_MANAGE'
        ];
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
        $response = $this->api->call('content/page/get-list', $params);
        $this->view->result = $response->data;
        $this->view->render('content/page/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('content/page/form');
        } else {
            // $data = $this->input->getArray();
			$data = $_POST;
            $response = $this->api->call('content/page/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('content/page/index'));
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
            $response = $this->api->call('content/page/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->page;
            $this->view->render('content/page/form');
        } else {
            // $data = $this->input->getArray();
			$data = $_POST;
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('content/page/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'content/page/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}