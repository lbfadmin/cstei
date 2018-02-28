<?php
/**
 * Created by PhpStorm.
 * User: leio
 * Date: 2017/11/11
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;

/**
 * 海水养殖产量统计 
 * Class Power
 * @package Module\Producer\Controller\SaltwaterFish
 */
class BreedingProduction extends Auth
{


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
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_CULTURE_OUTPUT'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {

		$this->view->quarter = $this->quarter;
		
		//搜索所有的示范县
		$params = array();
		$params['parent_id'] = $_SESSION['user']->unit_id;
        $response = $this->api->call('producer/company-sample/get-list', $params);
		$companies = array();
		
		foreach($response->data->list as $k=>$v){
			$companies[$v->id] = $v->name;
		}
		// print_r($companies);
		// exit;
		$this->view->com = $response->data->list;
		
		$data = $this->input->getArray();
		if (!empty($_POST)) {
			//保存上传的数据 ，空默认为0
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			$data['time_updated'] = date('Y-m-d H:i:s');	//创建时间
			//校验该数据是否已经存在
			$params = array();
			$params['unit_id'] = $data['unit_id'];
			$params['quarter'] = $data['quarter'];
			$params['id'] = $data['id'];
			$response = $this->api->call('producer/breeding-production/is-exist', $params);
			// print_r($response->data->list);
			// exit;
			if($response->data->list){
				$this->message->set('该季度的数据已经存在', 'warning');
				$this->response->refresh();
			}
			if(!$data["id"]){
				unset($data['id']);
				$response = $this->api->call('producer/breeding-production/create', $data);
				if ($response->code === 'OK') {
					$this->message->set('添加成功', 'success');
					$this->response->redirect(url('/producer/saltwater-fish/breeding-production/index'));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}
			}else{
				$response = $this->api->call('producer/breeding-production/update', $data);
				if ($response->code === 'OK') {
					$this->message->set('修改成功', 'success');
					$this->response->redirect(url('/producer/saltwater-fish/breeding-production/index'));
				} else {
					$this->message->set($response->message, 'error');
					$this->response->refresh();
				}
			}
		}
	
		
        $data = $this->input->getArray();
		$params = array();
		$params['page'] = $data['page'];//
		$params['limit'] = 20;//
        //获取示范县的养殖数据
		if($data['unit_id']){
			$params['unit_id'] = $data['unit_id'];
			$params['quarter'] = $data['quarter'];//选择的季度
			$response = $this->api->call('producer/breeding-production/get-list', $params);

			foreach($response->data->list as $k=>$item){
				$response->data->list[$k]->unit_name = $com[$item->unit_id];
			}
			$this->view->result = $response->data;
		}else{
			$m = new UserRoleModel();
			
			$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
			$roleid = $role[0]->roleId;
			if($roleid==1 || $roleid==15){
	
			}
			//角色为管理员 or 老师时候 取得下面试验站的累积的数据
			
			//角色为试验站长时候，获取该试验站下面所有的示范县的数据
			if($roleid==16){
				$params['unit_ids'] = implode(",", array_keys($companies));
				$params['quarter'] = $data['quarter'];//选择的季度
				if($params['unit_ids']){
					$response = $this->api->call('producer/breeding-production/get-list', $params);
					foreach($response->data->list as $k=>$v){
						$response->data->list[$k]->unit_name = $companies[$v->unit_id];
						$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
					}
					$this->view->result = $response->data;
				}
			}
		}
		if($this->view->result->total){
			$pager = new Pager();
			$this->view->pager = $pager->render([
			'limit' => $params['limit'],
			'total' => $response->data->total
			]);
		}
		$this->view->search = $data;
        $this->view->render('producer/breeding/production');
    }
}