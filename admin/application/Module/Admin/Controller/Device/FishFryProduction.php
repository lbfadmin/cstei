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
 * 五、本季度示范区县海水鱼苗种生产情况
 * Class AdultfishProduction
 * @package Module\Producer\Controller\SaltwaterFish
 */
class FishFryProduction extends Auth
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
            '__ALL__' => 'PRODUCER_FISHFRY_PRODUCTION'
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
				'id' => $parent_id
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
		$params['limit'] = 15;//
		if($data['unit_id']){

		}else{
			$data['unit_id']=$_SESSION['user']->unit_id;
		}
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
			$this->view->cats = json_decode($this->getFishArray($data['unit_id']));

			if($params['unit_ids'] ){
				$response = $this->api->call('producer/breeding-fry/get-list', $params);
				foreach($response->data->list as $k=>$v){
					$response->data->list[$k]->unit_name = $companies[$v->unit_id];
					$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
				}
				$this->view->result = $response->data;
			}
		}
		$type_arr = array(1=>"面积（M2）",2=>"本季销售量（万尾）",3=>"本季末存量（万尾）");
		$this->view->type_arr = $type_arr;
		if($this->view->result->total){
			$pager = new Pager();
			$this->view->pager = $pager->render([
			'limit' => $params['limit'],
			'total' => $response->data->total
			]);
		}
		$this->view->result = $response->data;
        $this->view->render('producer/station/fish-fry-production/index');
    }

	//校验录入的数据的正确性
	function validation($data){
			//保存上传的数据 ，空默认为0
			$param = array();
			$param['unit_id'] = $data['unit_id'];	//示范县
			$param['quarter'] = $data['quarter'];	//季度
			if($data['id']) $param['id'] = $data['id'];	//数据编号
            $result = $this->api->call('producer/breeding-fry/get_list', $param);
			// print_r($result);
			// exit;
			return $result->data->list;
	}
	
    /**
     * 添加
     */
    public function add()
    {	
        if (empty($_POST)) {
			$data = $this->input->getArray();
			if($data['unit_id']){
				
				//取得试验站现在养殖的鱼类
				$response = $this->api->call('producer/company-sample/get-item', [
					'id' => $data['unit_id']
				]);
				$this->view->cats = json_decode($this->getFishArray($data['unit_id']));
				// $unit_name = $response->data->production_unit->name; 
				$this->view->unit_name = $response->data->production_unit->name;//试验站名称
				$this->view->unit_id = $response->data->production_unit->id;
				
					
				//取得正在养殖的鱼类数据，按照季度逆序
				$response = $this->api->call('producer/breeding-fry/get-list', [
					'unit_id' => $data['unit_id']
				]);
			}
			$this->view->quarter = $this->quarter;
			// print_r($this->view->quarter);
			// exit;
            $this->view->render('producer/station/fish-fry-production/form');
        } else {
			//校验该示范县的季度数据是否已经上传
			
			//保存上传的数据 ，空默认为0
            $data = $this->input->getArray();
			if($this->validation($data)){
				
                $this->message->set('该季度对应数据已经存在！', 'warning');
                $this->response->redirect(url('producer/saltwater-fish/fish-fry-production/index?unit_id='.$data['unit_id']));
			}
			// exit;
			$unit_id = $data['unit_id'];	//试验站
			$response = $this->api->call('producer/breeding-fry/get-list', $data);
		
			if($response->data->list){	
		
                $this->message->set($this->quarter[$data['quarter']]."数据已经存在！", 'error');
                $this->response->refresh();
			}
			
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			
			$data["area"]['unit_id'] = $unit_id;	//试验站
			$data["area"]['time_created'] = $data['time_created'];	//创建时间
			$data["area"]['quarter'] = $data['quarter'];	//季度
			$data["area"]['type'] = 1;	//面积（M2）
			
			$data["sale"]['unit_id'] = $unit_id;	//试验站
			$data["sale"]['time_created'] = $data['time_created'];	//创建时间
			$data["sale"]['quarter'] = $data['quarter'];	//季度
			$data["sale"]['type'] = 2;	//本季销售量（万尾）

			$data["storage"]['unit_id'] = $unit_id;	//试验站
			$data["storage"]['time_created'] = $data['time_created'];	//创建时间
			$data["storage"]['quarter'] = $data['quarter'];	//季度
			$data["storage"]['type'] =3;	//本季末存量（万尾）

			// print_r($data["area"]);
			// print_r($data["sale"]);
			// print_r($data["storage"]);
			
			// exit;
            $response = $this->api->call('producer/breeding-fry/create', $data['area']);
			// print_r($response);
            $response = $this->api->call('producer/breeding-fry/create', $data['sale']);
			// print_r($response);
            $response = $this->api->call('producer/breeding-fry/create', $data['storage']);
			// print_r($response);

			// exit;
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/fish-fry-production/index?unit_id='.$data['unit_id']));
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

    /**
     * 编辑
     */
    public function edit()
    {
        if (empty($_POST)) {
			
			$this->view->quarter = $this->quarter;
            $response = $this->api->call('producer/breeding-fry/get-item', [
                'id' => $this->input->getInt('id')
            ]);
			$item = $response->data->production_unit;
            $this->view->item = $item;

			$this->view->cats = json_decode($this->getFishArray($item->unit_id));
		
			//取得试验站现在养殖的鱼类
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $item->unit_id
			]);
		
			$this->view->unit_name = $response->data->production_unit->name;//试验站名称
			$this->view->unit_id = $response->data->production_unit->id;
		
            $this->view->render('producer/station/fish-fry-production/edit');
            // $this->view->render('producer/statistics/annual-trend/form');
        } else {
            $data = $this->input->getArray();
			
            $ref = $this->input->getString('ref', '');
			// $this->view->quarter = $this->quarter;
            $response = $this->api->call('/producer/breeding-fry/update', $data);

            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/fish-fry-production/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
			

        }
    }
}