<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-16
 * Time: 下午2:06
 */

namespace Module\Producer\Controller\SaltwaterFish;

use Module\Account\Controller\Auth;
use Module\Account\Model\UserRoleModel;
use System\Component\Pager\Pager;

/**
 * 海水鱼成鱼养殖面积
 * Class Project
 * @package Module\Producer\Controller\SaltwaterFish
 */
class AdultFishArea extends Auth
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
            '__ALL__' => 'PRODUCER_ADULTFISH_CLUTURE_AREA'
        ];
    }

	
	function getFishArray($unit_id){
		
		//unit_id是试验站的场合
		$response = $this->api->call('producer/company-sample/get-item', [
			// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
			'id' => $unit_id//$_SESSION['user']->unit_id
		]);
	
		$parent_id = $response->data->production_unit->parent_id;
		if($parent_id){
			$unit_name = $response->data->production_unit->name;
			$unit_id = $response->data->production_unit->id;
			
			$response = $this->api->call('producer/company-sample/get-item', [
				// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
				'id' => $parent_id//$_SESSION['user']->unit_id
			]);
		}	
		return $response->data->production_unit->saltwater_fish;

	}
    /**
     * 列表
     */
    public function index()
    {	
		$this->view->quarter = $this->quarter;
		//取得试验站下面的所有示范县
		//搜索所有的示范县
		$params = array();
		$params['parent_id'] = $_SESSION['user']->unit_id;
        $response = $this->api->call('producer/company-sample/get-list', $params);
		$this->view->com = $response->data->list;
		$companies = array();
		foreach($response->data->list as $k=>$v){
			$companies[$v->id] = $v->name;
		}
		//获取全部的养殖鱼类

		$way_arr = array(1=>"工厂化（M2）",2=>"网箱（M2）",3=>"池塘（亩）");
		$this->view->way_arr = $way_arr;
		
		//取得当前试验站养殖的鱼类
		$data = $this->input->getArray();
		$params = array();
		$params['page'] = $data['page'];//选择的季度
		$params['limit'] = 20;//选择的季度
		
		if($data['unit_id']){
			
			//取得当前示范县区
			$response = $this->api->call('producer/company-sample/get-item', [
				// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
				'id' => $data['unit_id']//$_SESSION['user']->unit_id
			]);
			$parent_id = $response->data->production_unit->parent_id;
			
			$unit_name = $response->data->production_unit->name;
			$unit_id = $response->data->production_unit->id;

			$this->view->cats = json_decode($this->getFishArray($data['unit_id']));

			//取得当前试验站的养殖面积
			
			$response = $this->api->call('producer/adult-fish-area/get-list', [
				'unit_id' => $data['unit_id']//$_SESSION['user']->unit_id
			]);
			foreach($response->data->list as $k=>$item){
				$response->data->list[$k]->unit_name = $unit_name;
					$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
			// print_r($response->data->list[$k]->unit_name);
				// $response->data->list[$k]->unit_name = $unit_name;
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
				// 
				$params['unit_ids'] = implode(",", array_keys($companies));//$data['unit_id'];
				// $params['unit_ids'] = array_keys($companies);//$data['unit_id'];
				// $params['quarter'] = $data['quarter'];//$data['unit_id'];
				$params['quarter'] = $data['quarter'];//选择的季度
				$this->view->cats = json_decode($this->getFishArray($_SESSION['user']->unit_id));
				
				if($params['unit_ids']){
					$response = $this->api->call('producer/adult-fish-area/get-list', $params);
			
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
        $this->view->render('producer/station/adult-fish-area/index');
    }

    /**
     * 添加
     */
    public function add()
    {
		
		$this->view->quarter = $this->quarter;
		$data = $this->input->getArray();
        if (empty($_POST)) {
				//取得当前试验站养殖的鱼类
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $data['unit_id']
			]);
			$this->view->item = $response->data->production_unit;
			$this->view->item->saltwater_fish = $this->getFishArray($_SESSION['user']->unit_id);
			// print_r($this->view->item);
            $this->view->render('producer/station/adult-fish-area/form');
        } else {

			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			
			//校验该数据是否已经存在
			if($this->validation($data)) {
				$this->message->set("该季度的对应养殖方式的数据已经存在！", 'error');
				$this->response->refresh();
			}
            $response = $this->api->call('producer/adult-fish-area/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-area/index?unit_id='.$data['unit_id']));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }

        }
    }
	
	function validation($data){
			//保存上传的数据 ，空默认为0
			$param = array();
			$param['unit_id'] = $data['unit_id'];	//示范县
			$param['way_id'] = $data['way_id'];	//养殖方式
			$param['quarter'] = $data['quarter'];	//季度
	
			if($data['id']) $param['id'] = $data['id'];	//数据编号
			
            $result = $this->api->call('producer/adult-fish-area/is_exist', $param);
			// print_r($result);
			// exit;
			return $result->data->list;

	}
	
   /**
     * 添加
     */
    public function update()
    {
		$data = $this->input->getArray();
		//校验该数据是否已经存在
		if($this->validation($data)) {
			$this->message->set("该季度的对应养殖方式的数据已经存在！", 'error');
			$this->response->redirect(url('producer/saltwater-fish/adult-fish-area/index?unit_id='.$data['unit_id']));
		}
			
		$response = $this->api->call('producer/adult-fish-area/update', $data);

		if ($response->code === 'OK') {
			$this->message->set('保存成功', 'success');
			$this->response->redirect(url('producer/saltwater-fish/adult-fish-area/index?unit_id='.$data['unit_id']));
		} else {
			$this->message->set($response->message, 'error');
			$this->response->refresh();
		}
    }
}