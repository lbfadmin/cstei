<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:17
 */

namespace Module\Producer\Controller\Statistics;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理企业年度营收趋势
 * Class AnnualTrend
 * @package Module\Producer\Controller\Statistics
 */
class AnnualTrend extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'producer/statistics/annual-trend/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STATISTICS_ANNUAL_TREND'
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
			
			$data["area"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["area"]['time_created'] = $data['time_created'];	//创建时间
			$data["area"]['quarter'] = $data['quarter'];	//季度
			$data["area"]['type'] = 1;	//面积（M2）
			
			$data["sale"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["sale"]['time_created'] = $data['time_created'];	//创建时间
			$data["sale"]['quarter'] = $data['quarter'];	//季度
			$data["sale"]['type'] = 2;	//本季销售量（万尾）

			$data["storage"]['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data["storage"]['time_created'] = $data['time_created'];	//创建时间
			$data["storage"]['quarter'] = $data['quarter'];	//季度
			$data["storage"]['type'] =3;	//本季末存量（万尾）

			// print_r($data["area"]);
			// print_r($data["sale"]);
			// print_r($data["storage"]);
			
			// exit;
            $response = $this->api->call('producer/breeding-fry/create', $data['area']);
            $response = $this->api->call('producer/breeding-fry/create', $data['sale']);
            $response = $this->api->call('producer/breeding-fry/create', $data['storage']);

            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/annual-trend/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
		}
		
		//取得试验站现在养殖的鱼类
		$response = $this->api->call('project/production-unit/get-item', [
			'id' => $_SESSION['user']->unit_id
		]);
		$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		
		//取得正在养殖的鱼类数据，按照季度逆序
		$response = $this->api->call('producer/breeding-fry/get-list', [
			'unit_id' => $_SESSION['user']->unit_id
		]);
// print_r($response);
// exit;
		$type_arr = array(1=>"面积（M2）",2=>"本季销售量（万尾）",3=>"本季末存量（万尾）");
		$this->view->type_arr = $type_arr;
		
		$this->view->result = $response->data;
        $this->view->render('producer/statistics/annual-trend/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('producer/statistics/annual-trend/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/ProducerAnnualTrend/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/annual-trend/index'));
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
            $response = $this->api->call('project/ProducerAnnualTrend/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('producer/statistics/annual-trend/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/ProducerAnnualTrend/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/statistics/annual-trend/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}