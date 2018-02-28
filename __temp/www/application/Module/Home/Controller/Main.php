<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-4-14
 * Time: 上午10:51
 */

namespace Module\Home\Controller;


use Application\Controller\Front;

/**
 * 首页
 * Class Main
 * @package Module\Home\Controller
 */
class Main extends Front
{

    /**
     * 首页
     */
    public function index()
    {
        // 监测点
        //$response = $this->api->call('supervisor/monitoring-point/get-all');
        //$this->view->monitoring_points = $response->data->list;
		
		//取得首页显示的市场经济

        $response = $this->api->call('project/production-env/get-list-latest');
		$this->view->market_economy = $response->data->list;
// print_r($this->view->market_economy);
// exit;
        // $this->view->monitoring_points = $response->data->list;
        $this->view->render('home/index');
    }

    /**
     * 大数据视图
     */
    public function dashboard()
    {
        // 监测点
        $response = $this->api->call('supervisor/monitoring-point/get-all');
        $this->view->monitoring_points = $response->data->list;
        // 预警信息
        $response = $this->api->call('supervisor/env-warning/get-list', ['limit' => 8]);
        $this->view->warnings = $response->data->list;
        $this->view->render('home/dashboard');
    }
    /**
     * 登录
     */
    public function login()
    {
        // 监测点
        // $response = $this->api->call('supervisor/monitoring-point/get-all');
        // $this->view->monitoring_points = $response->data->list;
        // 预警信息
        // $response = $this->api->call('supervisor/env-warning/get-list', ['limit' => 8]);
        // $this->view->warnings = $response->data->list;
        $this->view->render('home/login');
    }
}