<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-19
 * Time: 下午3:13
 */

namespace Module\Consumer\Controller;


use Module\Account\Controller\Auth;

/**
 * 管理电商平台
 * Class ShoppingPlatform
 * @package Module\Consumer\Controller
 */
class ShoppingPlatform extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONSUMER_SHOPPING_PLATFORM_MANAGE'
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
        $response = $this->api->call('content/shopping-platform/get-all', $params);
        $this->view->platforms = $response->data->platforms;
        $this->view->render('consumer/shopping-platform/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('consumer/shopping-platform/form');
        } else {
            $data = $this->input->getArray();
            if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
                $this->message->set('未选择图片', 'error');
                $this->response->refresh();
            }
            $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
            $response = $this->api->call('common/image/upload', $file);
            $data['picture'] = $response->data->key;
            $response = $this->api->call('content/shopping-platform/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('consumer/shopping-platform/index'));
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
            $response = $this->api->call('content/info/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->info;
            // 分类
            $response = $this->api->call('content/info-category/get-tree');
            $this->view->categories = $response->data->children;
            $this->view->render('content/shopping-platform/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            if (!empty($_FILES['picture']) && !$_FILES['picture']['error']) {
                $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
                $response = $this->api->call('common/image/upload', $file);
                $data['picture'] = $response->data->key;
            }
            $response = $this->api->call('content/info/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'content/shopping-platform/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}