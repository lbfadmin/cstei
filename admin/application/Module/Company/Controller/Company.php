<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-16
 * Time: 上午11:31
 */

namespace Module\Company\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;

/**
 * 管理企业信息
 * Class Company
 * @package Module\Producer\Controller
 */
class Company extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'company/company/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'COMPANY_MANAGE_BASIC'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
		
		$m = new UserRoleModel();
		
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;

		switch($roleid){
			case 1:// 1:系统管理员
				break;
			case 15:// 15：超级管理员
				//判断parent_id是否在$params数组中
				// if(array_key_exists('parent_id', $params)){
					// if(!$params['parent_id']){
						// unset($params['parent_id']);
					// }
				// }else{
					//// $params['parent_id']
				// }
				break;
			case 16:// 16：试验站长
				$params['id'] = $_SESSION['user']->unit_id;	
				break;
			default:
				break;
		}	
        $params['limit'] = 10;
        // $params['page'] = $data['page'];
        $response = $this->api->call('producer/company/get-list', $params);
		// print_r($response);
		// exit;
        $this->view->result = $response->data;

        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('company/company/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('company/company/form');
        } else {
            $data = $this->input->getArray();
            // if (empty($_FILES['logo']) || $_FILES['logo']['error']) {
                // $this->message->set('未选择LOGO', 'error');
                // $this->response->refresh();
            // }
            // $file['logo'] = new \CURLFile($_FILES['logo']['tmp_name'], null, 'logo');
            // $response = $this->api->call('common/image/upload', $file);
            // $data['logo'] = $response->data->key;
            $response = $this->api->call('producer/production-unit/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('company/company/index'));
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
            $response = $this->api->call('producer/company/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->production_unit;
            $this->view->render('producer/company/company/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('producer/company/update', $data);
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