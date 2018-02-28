<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-19
 * Time: 上午10:46
 */

namespace Module\Consumer\Controller\Goods;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理商品
 * Class Goods
 * @package Module\Consumer\Controller\Goods
 */
class Goods extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_GOODS_MANAGE'
        ];
    }

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'consumer/goods/goods/index';
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
        $response = $this->api->call('content/goods/search', $params);
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->result = $response->data;
        $this->view->render('consumer/goods/goods/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $response = $this->api->call('content/goods-category/get-tree');
            $this->view->categories = $response->data->children;
            $this->view->render('consumer/goods/goods/form');
        } else {
            $data = $this->input->getArray();
            if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
                $this->message->set('未选择图片', 'error');
                $this->response->refresh();
            }
            $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
            $response = $this->api->call('common/image/upload', $file);
            $data['picture'] = $response->data->key;
            $response = $this->api->call('content/goods/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('consumer/goods/goods/index'));
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
            $response = $this->api->call('content/goods/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->goods;
            // 分类
            $response = $this->api->call('content/goods-category/get-tree');
            $this->view->categories = $response->data->children;
            $this->view->render('consumer/goods/goods/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            if (!empty($_FILES['picture']) && !$_FILES['picture']['error']) {
                $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
                $response = $this->api->call('common/image/upload', $file);
                $data['picture'] = $response->data->key;
            }
            $response = $this->api->call('content/goods/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'consumer/goods/goods/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}