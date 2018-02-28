<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;
// use System\Component\Validator\Validator;

/**
 * 养殖面积
 * Class CultureArea
 * @package Module\Producer\Controller\SaltwaterFish
 */
class CultureArea extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_CULTURE_AREA'
        ];
    }
	
	var $quarter = array();
    public function __construct($args = array()) {
        parent::__construct($args);
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");
    }
    /**
     * 列表
     */
    public function index()
    {

		$this->view->quarter = $this->quarter;
		//取得登录账号的角色
		$m = new UserRoleModel();
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;

		if (!empty($_POST)) {
			$data = $this->input->getArray();
			// $data['limit']=9999;
			//保存上传的数据 ，空默认为0
			// $data['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			$data['time_updated'] = date('Y-m-d H:i:s');	//创建时间

			
			//校验该数据是否已经存在
			$params = array();
			$params['unit_id'] = $data['unit_id'];
			$params['quarter'] = $data['quarter'];
			$params['id'] = $data['id'];
			$response = $this->api->call('producer/breeding-area/is-exist', $params);
			if($response->data->list){
				$this->message->set('该季度的数据已经存在', 'warning');
				$this->response->refresh();
			}

			if(!$data["id"]){
				unset($data['id']);
				$response = $this->api->call('producer/breeding-area/create', $data);
				if ($response->code === 'OK') {
					$this->message->set('添加成功', 'success');
					$this->response->redirect(url('/producer/saltwater-fish/culture-area/index?unit_id='.$data['unit_id']));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}
			}else{
				$response = $this->api->call('producer/breeding-area/update', $data);
		
				if ($response->code === 'OK') {
					$this->message->set('修改成功', 'success');
					$this->response->redirect(url('/producer/saltwater-fish/culture-area/index'));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}
			}
		}
		$data = $this->input->getArray();

		$params = array();
		
		$params['page'] = $data['page'];//选择的季度
		$params['limit'] = 20;//选择的季度
		$this->view->editable = 1;
		if($roleid==15){
			$this->view->editable = 0;//老师权限 不可编辑上传
		}
			if($roleid==1 || $roleid==15){//管理员权限和老师权限
				//取得所有的试验站
				$response = $this->api->call('producer/company/get-all', ['parent_id'=>0]);
				$this->view->pcom = $response->data->list;

				$companies = array();
				if($data['parent_id']){
					$response = $this->api->call('producer/company-sample/get-list', ["parent_id"=>$data['parent_id']]);
					$this->view->com = $response->data->list;				
					foreach($response->data->list as $k=>$v){
						$companies[$v->id] = $v->name;
					}
				}else{
					foreach($this->view->pcom as $k=>$v){
						$companies[$v->id] = $v->name;
					}
				}
				// $params = array();
				$params['quarter'] = $data['quarter'];//选择的季度

				if($data['unit_id']){//示范县区的场合
					$params['unit_id'] = $data['unit_id'];//选择的季度
					$response = $this->api->call('producer/breeding-area/get-list', $params);
					foreach($response->data->list as $k=>$v){
						$response->data->list[$k]->unit_name = $companies[$v->unit_id];
						$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
					}
					$this->view->result = $response->data;	
					//ok
				}else if($data['parent_id']){//试验站的场合 取得试验站的数据的合计 按照
					//取得试验站下属的示范县的数据
					$params['unit_ids'] = implode(",", array_keys($companies));//$data['unit_id'];
					$response = $this->api->call('producer/breeding-area/get-list', $params);
	
					foreach($response->data->list as $k=>$v){
						$response->data->list[$k]->unit_name = $companies[$v->unit_id];
						$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
					}
					$this->view->result = $response->data;
					//ok
				}else{
					//按照试验站进行合计
					$response = $this->api->call('producer/breeding-area/get-total', $params);
						// print_r($response);
					
					// exit;
					foreach($response->data->list as $k=>$v){
						$response->data->list[$k]->unit_name = $companies[$v->parent_id];
						$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
					}
					$this->view->result = $response->data;
					
					// exit;
				}
				
			}
			//角色为管理员 or 老师时候 取得下面试验站的累积的数据
			
			//角色为试验站长时候，获取该试验站下面所有的示范县的数据
			if($roleid==16){
				//搜索所有的示范县
				// $params = array();
				
				$params['quarter'] = $data['quarter'];//选择的季度
				$params['parent_id'] = $_SESSION['user']->unit_id;
				$response = $this->api->call('producer/company-sample/get-list', $params);
				$companies = array();
			
				foreach($response->data->list as $k=>$v){
					$companies[$v->id] = $v->name;
				}
				$this->view->com = $response->data->list;
				
				if($data['unit_id']){
					$params['unit_id'] = $data['unit_id'];

				}else{
					
					$params['unit_ids'] = implode(",", array_keys($companies));//$data['unit_id'];
					
				}
				if($params['unit_ids']||$data['unit_id']){
					$response = $this->api->call('producer/breeding-area/get-list', $params);
				
					foreach($response->data->list as $k=>$v){
						$response->data->list[$k]->unit_name = $companies[$v->unit_id];
						$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
					}
				}

					// print_r($params);
				// exit;

				$this->view->result = $response->data;
			}
		
		if($this->view->result->total){
			$pager = new Pager();
			$this->view->pager = $pager->render([
			'limit' => $params['limit'],
			'total' => $response->data->total
			]);
		}
		$this->view->search = $data;
        $this->view->render('producer/station/culture-area/index');
    }
}