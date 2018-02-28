<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:18
 */

namespace Module\Producer\Controller\Statistics;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理企业产业比重
 * Class IndustryWeight
 * @package Module\Producer\Controller\Statistics
 */
class IndustryWeight extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'producer/statistics/industry-weight/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STATISTICS_INDUSTRY_WEIGHT'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
		
        if (!empty($_POST)) {
			//保存上传的数据 ，空默认为0
			
            $data = $this->input->getArray();
			$data['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			
			$data["str"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["str"]['time_created'] = $data['time_created'];	//创建时间
			$data["str"]['way_id'] = $data['way_id'];	//养殖方式
			$data["str"]['quarter'] = $data['quarter'];	//季度
			$data["str"]['type'] = 1;	//季度
			
			$data["pre_a"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["pre_a"]['time_created'] = $data['time_created'];	//创建时间
			$data["pre_a"]['way_id'] = $data['way_id'];	//养殖方式
			$data["pre_a"]['quarter'] = $data['quarter'];	//季度
			$data["pre_a"]['type'] = 2;	//季度

			$data["pre_w"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["pre_w"]['time_created'] = $data['time_created'];	//创建时间
			$data["pre_w"]['way_id'] = $data['way_id'];	//养殖方式
			$data["pre_w"]['quarter'] = $data['quarter'];	//季度
			$data["pre_w"]['type'] = 3;	//季度
			
			$data["sal_a"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["sal_a"]['time_created'] = $data['time_created'];	//创建时间
			$data["sal_a"]['way_id'] = $data['way_id'];	//养殖方式
			$data["sal_a"]['quarter'] = $data['quarter'];	//季度
			$data["sal_a"]['type'] = 4;	//季度

			$data["sal_w"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["sal_w"]['time_created'] = $data['time_created'];	//创建时间
			$data["sal_w"]['way_id'] = $data['way_id'];	//养殖方式
			$data["sal_w"]['quarter'] = $data['quarter'];	//季度
			$data["sal_w"]['type'] = 5;	//季度

            $response = $this->api->call('project/breeding-production/create', $data['pre_a']);
			// print_r($response);
            $response = $this->api->call('project/breeding-production/create', $data['pre_w']);
			// print_r($response);
            $response = $this->api->call('project/breeding-production/create', $data['sal_a']);
			// print_r($response);
            $response = $this->api->call('project/breeding-production/create', $data['sal_w']);
			// print_r($response);
 
			// exit;
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/industry-weight/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
		}
        // $params = $this->input->getArray();
        // $response = $this->api->call('project/ProducerIndustryWeight/get-tree', $params);
        // $this->view->industrys = $response->data->children;
		$response = $this->api->call('project/production-unit/get-item', [
			'id' => $_SESSION['user']->unit_id
		]);

		//取得试验站现在养殖的鱼类
		$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		
		//取得正在养殖的鱼类数据，按照季度逆序
		
		$response = $this->api->call('project/breeding-production/get-list', [
			'unit_id' => $_SESSION['user']->unit_id
		]);
		// foreach($response->data->list as $k=>$v){
			
		// }
		$way_arr = array(1=>"工厂化（吨）",2=>"网箱（吨）",3=>"池塘（吨）");
		$this->view->way_arr = $way_arr;
		
		
		$type_arr = array(1=>"本季末存量",2=>"待养成鱼 万尾",3=>"待养成鱼 吨",4=>"商品鱼 万尾",5=>"商品鱼 吨");
		$this->view->type_arr = $type_arr;
		
		$this->view->result = $response->data;
        $this->view->render('producer/statistics/industry-weight/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {			
			// print_r($_POST['pre_a']);
			// exit;
            //$this->view->render('producer/statistics/industry-weight/form');
        } else {
            $data = $this->input->getArray();
			// print_r($data);
			// exit;
            $response = $this->api->call('project/breeding-production/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/industry-weight/index'));
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
            $response = $this->api->call('project/ProducerIndustryWeight/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('producer/statistics/industry-weight/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/ProducerIndustryWeight/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/statistics/industry-weight/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}