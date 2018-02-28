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
 * 季度末海水鱼成鱼塘边现价（单位：元/斤）
 * Class FishPrice
 * @package Module\Producer\Controller\SaltwaterFish
 */
class AdultFishPrice extends Auth
{
	var $quarter = array();
	var $type_arr = array();
    public function __construct($args = array()) {
        parent::__construct($args);
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");

		$this->type_arr = array(1=>"标准规格",2=>"超标准");
        $this->view->activePath = 'producer/station/channel-weight/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_SALTWATERFISH_PRICE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
		$this->view->quarter = $this->quarter;
		$this->view->type_arr = $this->type_arr;
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
		if($data['unit_id']){//搜索的场合

		}else{
			$data['unit_id'] = $_SESSION['user']->unit_id;
		}
		$m = new UserRoleModel();
		
	
		$params = array();
		$params['page'] = $data['page'];//
		$params['limit'] = 20;//
		$role = $m->getAll(array("userId"=>$_SESSION['user']->uid));
		$roleid = $role[0]->roleId;
		if($roleid==1 || $roleid==15){

		}
		//角色为管理员 or 老师时候 取得下面试验站的累积的数据
		
		//角色为试验站长时候，获取该试验站下面所有的示范县的数据
		if($roleid==16){
			$params['unit_ids'] = implode(",", array_keys($companies));
			$params['quarter'] = $data['quarter'];//选择的季度
			$this->view->cats = json_decode($this->getFishArray($data['unit_id']));//试验站下属的示范县区
			if($params['unit_ids']){
				$response = $this->api->call('producer/adult-fish-price/get-list', $params);
				foreach($response->data->list as $k=>$v){
					$response->data->list[$k]->unit_name = $companies[$v->unit_id];
					$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
				}
				$this->view->result = $response->data;
			}
		}
		$this->view->search = $data;

		if($this->view->result->total){
			$pager = new Pager();
			$this->view->pager = $pager->render([
			'limit' => $params['limit'],
			'total' => $response->data->total
			]);
		}
        $this->view->render('producer/station/adult-fish-price/index');
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
	
		// print_r($response);
		// exit;
		return $response->data->production_unit->saltwater_fish;

		//unit_id是示范县的场合的场合
		// return array();
	}
    /**
     * 添加
     */
    public function add()
    {
		$this->view->quarter = $this->quarter;
		$this->view->type_arr = $this->type_arr;
        $data = $this->input->getArray();
        if (empty($_POST)) {
			$response = $this->api->call('producer/company-sample/get-item', [
				'id' => $data['unit_id']
			]);

			//取得试验站现在养殖的鱼类
			$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
			$this->view->unit_id = $response->data->production_unit->id;
			$this->view->unit_name = $response->data->production_unit->name;

			$this->view->cats = json_decode($this->getFishArray($data['unit_id']));
			$this->view->quarter = $this->quarter;
            $this->view->render('producer/station/adult-fish-price/form');
        } else {
            //保存上传的数据 ，空默认为0
 			//校验该季度的养殖数据是否已经存在
			         // $data = $this->input->getArray();
			if($this->validation($data)){
				
                $this->message->set('该季度对应数据已经存在！', 'warning');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-price/index?unit_id='.$data['unit_id']));
			}

			$unit_id = $data['unit_id'];
            $response = $this->api->call('producer/adult-fish-price/get-list', ["unit_id"=>$unit_id, "quarter"=>$data['quarter']]);
			
			if($response->data->list){
                $this->message->set($this->quarter[$data['quarter']]."数据已经存在..", 'error');
                $this->response->refresh();
			}

            $data['time_created'] = date('Y-m-d H:i:s');    //创建时间
            
            $data["standard"]['unit_id'] = $unit_id;   //试验站
            $data["standard"]['time_created'] = $data['time_created'];   //创建时间
            $data["standard"]['quarter'] = $data['quarter']; //季度
            $data["standard"]['type'] = 1;   //标准规格
            
            $data["exceeding"]['unit_id'] = $unit_id; //试验站
            $data["exceeding"]['time_created'] = $data['time_created']; //创建时间
            $data["exceeding"]['quarter'] = $data['quarter'];   //季度
            $data["exceeding"]['type'] = 2; //超标准

            $response = $this->api->call('producer/adult-fish-price/create', $data['standard']);
            $response = $this->api->call('producer/adult-fish-price/create', $data['exceeding']);

            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-price/index?unit_id='.$data['unit_id']));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
		}
    }

	//校验录入的数据的正确性
	function validation($data){
			//保存上传的数据 ，空默认为0
			$param = array();
			$param['unit_id'] = $data['unit_id'];	//示范县
			$param['quarter'] = $data['quarter'];	//季度
			if($data['id']) $param['id'] = $data['id'];	//数据编号
            $result = $this->api->call('producer/adult-fish-price/get_list', $param);
		
			return $result->data->list;
	}
	
    /**
     * 编辑
     */
    public function edit()
    {
		$this->view->quarter = $this->quarter;
		$this->view->type_arr = $this->type_arr;
        if (empty($_POST)) {

			$this->view->quarter = $this->quarter;
            $response = $this->api->call('producer/adult-fish-price/get-item', [
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
		
            $this->view->render('producer/station/adult-fish-price/edit');
		
        } else {
            //保存上传的数据 ，空默认为0
           $data = $this->input->getArray();
			
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('producer/adult-fish-price/update', $data);
			// print_r($response);
			// exit;
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/saltwater-fish/adult-fish-price/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }
}