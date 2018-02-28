<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-7
 * Time: 下午4:52
 */

namespace Module\Content\Controller;


use Application\Controller\Front;

/**
 * 静态页
 * Class Page
 * @package Module\Content\Controller
 */
class Page extends Front
{

    /**
     * 详情页
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $pageId = 2;//(int)$name;
		// echo  $pageId ;
		// exit;
        $response = $this->api->call('content/page/get-item', [
            'id' => $pageId
        ]);
        $this->view->page = $response->data->page;
        $this->view->title = $this->view->page->title;
        $this->view->render('content/page/view');
    }
	
	 /**
     * 体系简介、专家团队、试验站下的列表
     * @param $name
     * @param $arguments
     */
	public function getCategories(){
		//获取体系简介下面的文章
		$response = $this->api->call('content/info/get-list', [
            'category_id' => 42,"limit"=>30
        ]);
		$this->view->systembrief=$response->data;

		//取得专家团队列表
		$response = $this->api->call('content/info/get-all', [
            'category_id' => 36,"limit"=>30
        ]);
		$this->view->expertteam=$response->data;
		
		//获取试验站列表
		$response = $this->api->call('content/info/get-all', [
            'category_id' => 37,"limit"=>30
        ]);
		$this->view->teststation=$response->data;
	}
    /**
     * 体系简介
     * @param $name
     * @param $arguments
     */
    public function brief()
    {

        $params = $this->input->getArray();
		$this->getCategories();

		//获取体系简介
		$response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);

        $this->view->page = $response->data->info;
        $this->view->title = $this->view->page->title;
        $this->view->render('content/page/brief');
    }

	/**
     * 专家团队
     * @param $name
     * @param $arguments
     */
    public function expertTeamDetail()
    {
        
        $params = $this->input->getArray();
		$this->getCategories();

		//获取专家团队内容
		$response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);

        $this->view->page = $response->data->info;
        //$this->view->page = $response->data->page;
        $this->view->title = $this->view->page->title;
        $this->view->render('content/page/expert');
    }
	
    /**
     * 试验站
     * @param $name
     * @param $arguments
     */
    public function testStation()
    {
        
        $params = $this->input->getArray();
		$this->getCategories();

        //获取/**内容
		//获取试验站的基本信息
        // $response = $this->api->call('content/info/get-item', [
            // 'id' => $params['id']
        // ]);
          $response = $this->api->call('project/production-unit/get-station', [
                'name' => $params['name']
            ]);

		
        $this->view->pid = $params['id'];
        $this->view->page = $response->data->production_unit;
        $this->view->title = $this->view->page->name;
        $this->view->render('trace/teststation');
    }
	/**
     * 试验站
     * @param $name
     * @param $arguments
     */
    public function testStationDetail()
    {
        
        $params = $this->input->getArray();
		$this->getCategories();

		//获取/**内容
		$response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);

        $this->view->page = $response->data->info;
        $this->view->title = $this->view->page->title;
        $this->view->render('content/page/station');
    }
}
	
    /**
     * 专家团队
     * @param $name
     * @param $arguments
    public function expertTeam()
    {
		
        $params = $this->input->getArray();
		// $params['parentId']=17;//产业文化
        // $pageId = 2;//$this->input->getInt('id');
		// echo  $pageId ;
		// exit;
        $response = $this->api->call('content/page/expert-team', [
            'id' => $pageId
        ]);
		
		
		//取得专家团队列表
		$response = $this->api->call('content/page/expert-team', [
            'id' => $pageId
        ]);
		
		//获取专家团队内容
		$response = $this->api->call('content/page/expert-team-detail', [
            'id' => $pageId
        ]);
		
        $this->view->page = $response->data->page;
        $this->view->title = $this->view->page->title;
        $this->view->render('content/page/brief');
    }
     */