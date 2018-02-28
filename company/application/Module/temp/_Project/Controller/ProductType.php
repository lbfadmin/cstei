<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-16
 * Time: 下午2:06
 */

namespace Module\Project\Controller;


use Module\Account\Controller\Auth;

/**
 * 管理产品类型
 * Class ProductType
 * @package Module\Project\Controller
 */
class ProductType extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PROJECT_PRODUCT_TYPE_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $response = $this->api->call('project/product-type/get-all');
        $this->view->list = $response->data->list;
        $this->view->render('project/product-type/index');
    }

    /**
     * 添加
     */

    public function add()
    {
        
        if (empty($_POST)) {
            $response = $this->api->call('project/product-type-category/get-all');
            $this->view->categories = $response->data->list;
            $this->view->render('project/product-type/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/product-type/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('project/product-type/index'));
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
            $response = $this->api->call('project/product-type-category/get-all');
            $this->view->categories = $response->data->list;
            $response = $this->api->call('project/product-type/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('project/product-type/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/product-type/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'project/product-type/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}