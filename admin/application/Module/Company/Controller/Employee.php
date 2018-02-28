<?php
/**
 * Created by PhpStorm.
 * User: LEIO
 * Date: 16-12-16
 * Time: 上午11:31
 */

namespace Module\Company\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;
/**
 * 企业员工
 * Class Company
 * @package Module\Company\Controller
 */
class Employee extends Auth
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
     * 示范县列表
     */
    public function index()
    {
		//登录账号为试验站长时候，取得对应的示范县数据
		//取得试验站的编号
        $params = $this->input->getArray();
        $params['limit'] = 20;
		$m = new UserRoleModel();
		
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;
		
		
		
		switch($roleid){
			case 1:// 1:系统管理员
				break;
			case 15:// 15：超级管理员
				//判断parent_id是否在$params数组中
				if(array_key_exists('parent_id', $params)){
					if(!$params['parent_id']){
						unset($params['parent_id']);
					}
				}else{
					// $params['parent_id']
				}
				break;
			case 16:// 16：试验站长
				$params['parent_id'] = $_SESSION['user']->unit_id;	
				break;
			default:
				break;
			
		}

		//角色为管理员时候 设置parentid > 0
		//角色为试验站时候，parent_id = $_SESSION['user']->unit_id;	
		// $params['parent_id'] = 19;//$_SESSION['user']->unit_id;	//试验站
        $response = $this->api->call('producer/company-sample/get-list', $params);
        $this->view->result = $response->data;

		
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('producer/company/companySample/index');
    }

    /**
     * 添加
     */
    public function add()
    {
		$m = new UserRoleModel();
		
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;
        if (empty($_POST)) {
			//取得所有的试验站
			
			$params = array();
			//角色为管理员时候或者老师时候
			if($roleid==1 || $roleid==15){
				//取得综合试验站数据
				$params['parent_id'] = 0;
				$result = $this->api->call('producer/company/get-list', $params);
				$data = array();//$result->data->list;
					$this->view->data = $result->data;
			}
			//角色为试验站人员时候
            $this->view->render('producer/company/companySample/form');
        } else {
            $data = $this->input->getArray();
			unset($data['id']);

			$m = new UserRoleModel();
			
			$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
			$roleid = $role[0]->roleId;
			if($roleid==16){
				$data['parent_id'] = $_SESSION['user']->unit_id;	
			}
	
		
            // if (empty($_FILES['logo']) || $_FILES['logo']['error']) {
                // $this->message->set('未选择LOGO', 'error');
                // $this->response->refresh();
            // }
            // $file['logo'] = new \CURLFile($_FILES['logo']['tmp_name'], null, 'logo');
            // $response = $this->api->call('common/image/upload', $file);
            // $data['logo'] = $response->data->key;
            $response = $this->api->call('producer/company-sample/create', $data);
	
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/company/company-sample/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
			
	/*switch($roleid){
		
			case 1:// 1:系统管理员
				break;
			case 15:// 15：超级管理员
				$data['parent_id'] = $_SESSION['user']->unit_id;	
				//判断parent_id是否在$params数组中
				if(array_key_exists('parent_id', $params)){
					if(!$params['parent_id']){
						unset($params['parent_id']);
					}
				}else{
					// $params['parent_id']
				}
				break;
		
			case 16:// 16：试验站长
				$data['parent_id'] = $_SESSION['user']->unit_id;	
				break;
			default:
				break;
			
		}*/
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
		$m = new UserRoleModel();
		
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;
        if (empty($_POST)) {
			if($roleid==1 || $roleid==15){
				//取得综合试验站数据
				$params['parent_id'] = 0;
				$result = $this->api->call('producer/company/get-list', $params);
				$data = array();//$result->data->list;
				// foreach($result->data->list as $k=>$v){
					// $data[$v->id] = $v->name;
					
				// }
				$this->view->data = $result->data;
			}
			
		
            $response = $this->api->call('producer/company/get-item', [
                'id' => $this->input->getInt('id')
            ]);
			// print_r($response);
			// exit;
            $this->view->item = $response->data->production_unit;
            $this->view->render('producer/company/companySample/form');
        } else {
/*
			if($roleid==1 || $roleid==15){
				//取得综合试验站数据
				$params['parent_id'] = 0;
				$result = $this->api->call('producer/company/get-list', $params);
				$data = array();//$result->data->list;
				// foreach($result->data->list as $k=>$v){
					// $data[$v->id] = $v->name;
					
				// }
				$this->view->data = $result->data;
			}
*/
			
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