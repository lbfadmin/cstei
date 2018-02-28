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
			
			print_r($_POST['pre_a']);
			exit;
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
		print_r($response);
		// exit;
        $this->view->render('producer/statistics/industry-weight/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('producer/statistics/industry-weight/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/ProducerIndustryWeight/create', $data);
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