<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:17
 */

namespace Module\Producer\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;

/**
 * 本季度示范区县海水鱼成鱼养殖产量统计
 * Class AdultfishProduction
 * @package Module\Producer\Controller\SaltwaterFish
 */
class AdultFishProduction extends Auth
{
	var $quarter = array();
    public function __construct($args = array()) {
        parent::__construct($args);
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");

        $this->view->activePath = 'producer/statistics/annual-trend/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_ADULTFISH_PRODUCTION'
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
		$data = $this->input->getArray();
		$params = array();
		$params['page'] = $data['page'];//
		$params['limit'] = 20;//
		if($data['unit_id']){
			//取得试验站现在养殖的鱼类
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $data['unit_id']
			]);
			
			$this->view->cats = json_decode($this->getFishArray($data['unit_id']));

			$this->view->unit_id = $response->data->production_unit->id;
			$this->view->unit_name = $response->data->production_unit->name;
			
			$params['unit_id'] = $data['unit_id'];
			$params['quarter'] = $data['quarter'];//选择的季度
			//取得正在养殖的鱼类数据，按照季度逆序
			$response = $this->api->call('producer/adult-fish-production/get-list', $params);
			foreach($response->data->list as $k=>$v){
					$response->data->list[$k]->unit_name = $companies[$v->unit_id];
					$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
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
				$params['unit_ids'] = implode(",", array_keys($companies));//$data['unit_id'];
				$params['quarter'] = $data['quarter'];//选择的季度
				if($params['unit_ids']){
					$this->view->cats = json_decode($this->getFishArray($_SESSION['user']->unit_id));
					$response = $this->api->call('producer/adult-fish-production/get-list', $params);
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
		$type_arr = array(1=>"本季销售量（吨）",2=>"本季末存量 待养成鱼（万尾）",3=>"本季末存量 待养成鱼（吨）",4=>"本季末存量 商品鱼（万尾）",5=>"本季末存量 商品鱼（吨）");
		$this->view->type_arr = $type_arr;
		
		$way_arr = array(1=>"工厂化（吨）",2=>"网箱（吨）",3=>"池塘（吨）");
		$this->view->way_arr = $way_arr;
		$this->view->result = $response->data;
        $this->view->render('producer/station/adult-fish-production/index');
    }
	
	function validation($data){
			//保存上传的数据 ，空默认为0
			$param = array();
			$param['unit_id'] = $data['unit_id'];	//示范县
			$param['way_id'] = $data['way_id'];	//养殖方式
			$param['quarter'] = $data['quarter'];	//季度
	
			if($data['id']) $param['id'] = $data['id'];	//数据编号
			
            $result = $this->api->call('producer/adult-fish-production/get_list', $param);
			return $result->data->list;
	}
    /**
     * 添加
     */
    public function add()
    {

        if (empty($_POST)) {
			
			$this->view->quarter = $this->quarter;
			$data = $this->input->getArray();			
			if($data['unit_id']){
				
				
				$this->view->cats = json_decode($this->getFishArray($data['unit_id']));
				//取得试验站现在养殖的鱼类
				$response = $this->api->call('producer/company-sample/get-item', [
					'id' => $data['unit_id']
				]);
				// $this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
				// $unit_name = $response->data->production_unit->name; 
				$this->view->unit_name = $response->data->production_unit->name;//试验站名称
				$this->view->unit_id = $response->data->production_unit->id;

			}
            $this->view->render('producer/station/adult-fish-production/form');
        } else {
			//校验该示范县的季度数据是否已经上传
			//保存上传的数据 ，空默认为0
            $data = $this->input->getArray();
			if($this->validation($data)){
				
                $this->message->set('该示范县区对应的季度数据已经存在', 'error');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-production/index?unit_id='.$data['unit_id']));
			}
			// exit;
			$data['unit_id'] = $data['unit_id'];	//试验站
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			
			$data["str"]['unit_id'] = $data['unit_id'];	//试验站
			$data["str"]['time_created'] = $data['time_created'];	//创建时间
			$data["str"]['way_id'] = $data['way_id'];
			$data["str"]['quarter'] = $data['quarter'];	//季度
			$data["str"]['type'] = 1;	//面积（M2）
			
			$data["pre_a"]['unit_id'] = $data['unit_id'];	//试验站
			$data["pre_a"]['time_created'] = $data['time_created'];	//创建时间
			$data["pre_a"]['way_id'] = $data['way_id'];
			$data["pre_a"]['quarter'] = $data['quarter'];	//季度
			$data["pre_a"]['type'] = 2;	//本季销售量（万尾）

			$data["pre_w"]['unit_id'] = $data['unit_id'];	//试验站
			$data["pre_w"]['time_created'] = $data['time_created'];	//创建时间
			$data["pre_w"]['way_id'] = $data['way_id'];
			$data["pre_w"]['quarter'] = $data['quarter'];	//季度
			$data["pre_w"]['type'] =3;	//本季末存量（万尾）

			$data["sal_a"]['unit_id'] = $data['unit_id'];	//试验站
			$data["sal_a"]['time_created'] = $data['time_created'];	//创建时间
			$data["sal_a"]['way_id'] = $data['way_id'];
			$data["sal_a"]['quarter'] = $data['quarter'];	//季度
			$data["sal_a"]['type'] =4;	//本季末存量（万尾）

			$data["sal_w"]['unit_id'] = $data['unit_id'];	//试验站
			$data["sal_w"]['time_created'] = $data['time_created'];	//创建时间
			$data["sal_w"]['way_id'] = $data['way_id'];
			$data["sal_w"]['quarter'] = $data['quarter'];	//季度
			$data["sal_w"]['type'] =5;	//本季末存量（万尾）
			// print_r($data["area"]);
			// print_r($data["sale"]);
			// print_r($data["storage"]);
			
			// exit;
            $response = $this->api->call('producer/adult-fish-production/create', $data['str']);
			//print_r($response);
            $response = $this->api->call('producer/adult-fish-production/create', $data['pre_a']);
			//print_r($response);
            $response = $this->api->call('producer/adult-fish-production/create', $data['pre_w']);
			//print_r($response);
            $response = $this->api->call('producer/adult-fish-production/create', $data['sal_a']);
			//print_r($response);
            $response = $this->api->call('producer/adult-fish-production/create', $data['sal_w']);
			//print_r($response);

			// exit;
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-production/index?unit_id='.$data['unit_id']));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
			
/*
			$data = $this->input->getArray();
			//取得试验站现在养殖的鱼类
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $data['unit_id']
			]);
			$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
			$unit_name = $response->data->production_unit->name; //试验站名称
			
            $response = $this->api->call('project/ProducerAnnualTrend/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/annual-trend/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
*/
        }
    }
	function object_array($array) {  
		if(is_object($array)) {  
			$array = (array)$array;  
		 } if(is_array($array)) {  
			 foreach($array as $key=>$value) {  
				 $array[$key] = object_array($value);  
				 }  
		 }  
		 return $array;  
	}
    /**
     * 编辑
     */
    public function edit()
    {
        if (empty($_POST)) {

            $response = $this->api->call('/producer/adult-fish-production/get-item', [
                'id' => $this->input->getInt('id')
            ]);
			$item = $response->data->production_unit;
            $this->view->item = $item;
			$this->view->quarter = $this->quarter;
			$data = $this->input->getArray();			
			// if($data['unit_id']){
				
				
			$this->view->cats = json_decode($this->getFishArray($item->unit_id));
		
			//取得试验站现在养殖的鱼类
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $item->unit_id
			]);
			$this->view->unit_name = $response->data->production_unit->name;//试验站名称
			$this->view->unit_id = $response->data->production_unit->id;

			// }
		
			
            $this->view->render('producer/station/adult-fish-production/edit');
            // $this->view->render('producer/statistics/annual-trend/form');
        } else {
            $data = $this->input->getArray();
			
			$this->view->quarter = $this->quarter;
            $response = $this->api->call('/producer/adult-fish-production/update', $data);

            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-production/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}

			
/*
			$param = array();
			$param['unit_id'] = $item->unit_id;
			$param['quarter'] = $item->quarter;
			$param['way_id'] = $item->way_id;
			
	
					
            $response = $this->api->call('/producer/adult-fish-production/get-list', $param);
			// $list = $response->data->list;
			// exit;
					// print_r($this->object_array($response->data->list));
				// exit;
			$list = array();
			foreach($response->data->list as $k=>$v){
				$item = (array)$v;
				foreach(array_keys($item) as $_v){
					$list[$item['type']][$_v]=$item[$_v];
				}

			}
			foreach($list as $_v){
					
					print_r($_v);
					echo "<br>";
			}
			exit;
*/
		// $type_arr = array(1=>"本季销售量（吨）",2=>"本季末存量 待养成鱼（万尾）",3=>"本季末存量 待养成鱼（吨）",4=>"本季末存量 商品鱼（万尾）",5=>"本季末存量 商品鱼（吨）");
		// $this->view->type_arr = $type_arr;
			

			// $data = array();
			// foreach($item as )