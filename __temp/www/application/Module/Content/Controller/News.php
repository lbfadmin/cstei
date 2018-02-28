<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-8
 * Time: 下午4:42
 */

namespace Module\Content\Controller;


use Application\Controller\Front;
use System\Component\Pager\Pager;

/**
 * 新闻资讯
 * Class News
 * @package Module\Content\Controller
 */
class News extends Front
{

    /**
     * 详情
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
			// print_r($name);
			// exit;
        $newsId = (int) $name;
        $response = $this->api->call('content/info/get-item', [
            'id' => $newsId
        ]);
        $news = $response->data->info;
        $this->view->title = $news->title;
        $this->view->news = $news;
        $this->view->render('content/news/view');
    }

	    /**
     * 详情
     * @param $name
     * @param $arguments
     */
    public function newsDetail()
    {
        $params = $this->input->getArray();

		//取得新闻动态下的分类
		$params['parentId']=14;//新闻动态
        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;
		
		//取得文章内容
        $response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);
        $news = $response->data->info;
		$this->view->title_m = '新闻动态';	
        $this->view->title_c = $news->category_name;//
        $this->view->news = $news;
        $this->view->render('content/news/view-news');
    }
	
	 /**
     * 产业文化详情
     * @param $name
     * @param $arguments
     */
    public function cultureDetail()//$name, $arguments)
    {
        $params = $this->input->getArray();

		//取得产业文化下的分类
		$params['parentId']=15;//产业文化
        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;
		
		//取得文章内容
        $response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);
        $news = $response->data->info;
		$this->view->title_m = '产业文化';	
        $this->view->title_c = $news->category_name;//
        $this->view->news = $news;
        $this->view->render('content/news/view-culture');
    }
	
	 /**
     * 成果展示详情
     * @param $name
     * @param $arguments
     */
    public function achieveDetail()//$name, $arguments)
    {
        $params = $this->input->getArray();

		//取得成果展示下的分类
		$params['parentId']=16;//成果展示
        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;
		
		//取得文章内容
        $response = $this->api->call('content/info/get-item', [
            'id' => $params['id']
        ]);
        $news = $response->data->info;

		
		$this->view->title_m = '成果展示';	
        $this->view->title_c = $news->category_name;//
        $this->view->news = $news;
        $this->view->render('content/news/view-achieve');
    }
	
    /**
     * 新闻动态
     */
    public function index()
    {
		
		//取得新闻动态的分类
        $params = $this->input->getArray();
	
		$params['parentId']=14;//新闻动态

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;

        //$params = $this->input->getArray();
        $params['limit'] = 10;
        $params['published_only'] = 0;
        $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
		//获取category_id下所有的新闻
        $response = $this->api->call('content/info/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
		if(empty($params['category_id'])){
			$this->view->title = '新闻动态';	
		}else{
			
			$this->view->title = $params['name'];
		}
        $this->view->render('content/news/index');
    }
	
	    /**
     * 产业文化
     */
    public function culture()
    {
		//取得产业文化的分类
		
        $params = $this->input->getArray();
		$params['parentId']=15;//产业文化

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;
		// print_r($this->view->category->children);
// exit;
		
        //$params = $this->input->getArray();
        $params['limit'] = 10;
        $params['published_only'] = 0;
        $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
		//获取category_id下所有的新闻
        $response = $this->api->call('content/info/get-list', $params);
	
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
		if(empty($params['category_id'])){
			$this->view->title = '产业文化';	
		}else{
			
			$this->view->title = $params['name'];
		}
        $this->view->render('content/news/culture');
    }
	
	/**
     * 成果展示
     */
    public function achieve()
    {
		//取得产业文化的分类
		
        $params = $this->input->getArray();
		$params['parentId']=16;//产业文化

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;

        $params['limit'] = 10;
        $params['published_only'] = 0;
        $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
		// print_r($params);
		// exit;
		//获取category_id下所有的新闻
        $response = $this->api->call('content/info/get-list', $params);

        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
		if(empty($params['category_id'])){
			$this->view->title = '成果展示';	
		}else{
			
			$this->view->title = $params['name'];
		}
        $this->view->render('content/news/achieve');
    }
	
	/**
     * 产业文化
     */
    public function industryCulture()
    {
		//取得产业文化的分类

        $params = $this->input->getArray();
		$params['parentId']=17;//产业文化

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->categories = $response->data;
		// print_r($this->view->categories);
		// exit;

        //$params = $this->input->getArray();

		if(empty($params['category_id'])){
			$this->view->title = '产业文化';	
		}else{
			$this->view->title = $params['name'];
		}
		
		if($params['id']){
			
			//取得文章内容
			$response = $this->api->call('content/info/get-item', $params);
			
			$this->view->info = $response->data->info;
			// print_r($this->view->info);
			//ajax获取鱼类的产量曲线图
			$this->view->title =  $params['name'];
			// $this->view->render('content/news/view-indeustry');
			
		}else{
			$params['limit'] = 10;
			$params['published_only'] = 0;
			$params['page'] = $params['page'] ? $params['page'] + 1 : 1;
			//获取category_id下所有的新闻
			$response = $this->api->call('content/info/get-list', $params);
			// print_r($response);
		
			$this->view->result = $response->data;
			$pager = new Pager();
			$this->view->pager = $pager->render([
				'limit' => $params['limit'],
				'total' => $response->data->total
			]);
		}
		
			$this->view->render('content/news/industryculture');
        // $this->view->render('content/news/industryculture');
    }

	/**
     * 市场经济
     */
    public function marketEconomy()
    {
		//取得产业文化的分类
		
        $params = $this->input->getArray();
		$params['category_id']=18;//产业动态

        $response = $this->api->call('/project/product-type-category/get-all');
		
        $this->view->categories = $response->data;

		$this->view->id = 1;

		// //id不为空时候，根据id获取该鱼类的信息
		if($params['id']){

			$params['pool_id'] = $params['id'];
			$params['limit'] = 20;
			$pager = new Pager();
			$this->view->pager = $pager->render([
			'limit' => $params['limit'],
			'total' => $response->data->total
			]);
			//点击鱼类时候，获取最近的鱼类的市场行情 20条
			$response = $this->api->call('/project/production-env/get-list', $params);
		
			$this->view->result = $response->data;
	
		
			$this->view->id = $params['id'];
		}else{
		
			$params['name']='大菱鲆';
		}
		

        $this->view->render('content/news/market-economy');
    }
	
	/**
     * 产业动态
     */
    public function industryDynamics()
    {
		//取得产业动态分类
		
        $params = $this->input->getArray();
		$params['category_id']=18;//产业动态


		//获取category_id下所有的新闻
        $response = $this->api->call('content/info/get-list', $params);
		$this->view->result = $response->data;
/*
        //$params = $this->input->getArray();
        // $params['limit'] = 100;
        // $params['published_only'] = 0;
        // $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
		
		
		//取得所有的鱼类
		$response = $this->api->call('/project/product-type-category/get-all');
        $this->view->result = $response->data;
		
        // $pager = new Pager();
        // $this->view->pager = $pager->render([
            // 'limit' => $params['limit'],
            // 'total' => $response->data->total
        // ]);
*/

		//id不为空时候，根据id获取该鱼类的信息
		if($params['id']){
			//取得文章内容
			$response = $this->api->call('content/info/get-item', $params);
			$this->view->info = $response->data->info;
			//ajax获取鱼类的产量曲线图
			$this->view->title =  $params['name'];
		}
		$this->view->id = $params['id'];
		$this->view->title = $params['name'];
        $this->view->render('content/news/industrydynamics');
    }
	

	/**
     * 疾病防控
     */
    public function diseaseControl()
    {
        $params = $this->input->getArray();
	

		//取得疾病分类
		$params['parentId']=21;		

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->categories = $response->data;

		//$params['category_id']=21;//产业动态
        //$params = $this->input->getArray();

		//id不为空时候，根据id获取该鱼类的信息
		if($params['id']){//鱼类疾病详情
			
			//取得文章内容
			$response = $this->api->call('content/info/get-item', $params);
			
			$this->view->info = $response->data->info;
			// print_r($this->view->info);

			$this->view->id = $params['id'];
			
			// $params['name']=$this->view->info->title;//鱼类品种名称
			// $response = $this->api->call('project/production-yield/get-list', $params);
			
		}else{//鱼类疾病列表
			$params['limit'] = 100;
			$params['published_only'] = 0;
			$params['page'] = $params['page'] ? $params['page'] + 1 : 1;
			//获取category_id下所有的新闻
			
			$response = $this->api->call('content/info/get-list', $params);
			//print_r($response);
			// $this->view->result = $response->data;
			$this->view->result = $response->data;
			$pager = new Pager();
			$this->view->pager = $pager->render([
				'limit' => $params['limit'],
				'total' => $response->data->total
			]);
		}
		
		// if(empty($params['category_id'])){
			// $this->view->title = '产业动态';	
		// }else{
			
			$this->view->title = $params['name'];
		// }
        $this->view->render('content/news/diseasecontrol');
    }
	
	

	/**
     * 明星产品追溯系统
     */
    public function trace()
    {
		$params = $this->input->getArray();
	
		//取得明星产品追溯系统下级分类
		// $params['parentId']=38;		
		$response = $this->api->call('content/info-category/get-children', ["parentId"=>20]);
		$this->view->categories = $response->data;
		foreach($response->data->children as $k=>$v){
			// print_r($v->name);
			// exit;
			if($v->id == $params['category_id']){
				$this->view->category_name = $v->name;	
			}
		}
		// print_r([1]);
			// exit;
		//id不为空时候，根据id获取该鱼类的信息
		if($params['id']){//鱼类疾病详情
			
			//取得文章内容
			$response = $this->api->call('content/info/get-item', $params);
			
			$this->view->info = $response->data->info;
			//print_r($this->view->info);

			$this->view->id = $params['id'];
			
			// $params['name']=$this->view->info->title;//鱼类品种名称
			// $response = $this->api->call('project/production-yield/get-list', $params);
			
		}else{//鱼类疾病列表
			$params['parentId']=0;	
			$params['limit'] = 100;
			$params['published_only'] = 0;
			$params['page'] = $params['page'] ? $params['page'] + 1 : 1;
			//获取category_id下所有的新闻	
			$response = $this->api->call('content/info/get-list', $params);
			
			
			// $this->view->result = $response->data;
			$this->view->result = $response->data;
			$pager = new Pager();
			$this->view->pager = $pager->render([
				'limit' => $params['limit'],
				'total' => $response->data->total
			]);
		}
		

        $this->view->render('content/news/trace');
    }
	
	/**
     * 质量安全
     */
    public function qsmark()
    {
		$params = $this->input->getArray();
	
		//取得质量安全文章
		$params['parentId']=39;		
		$response = $this->api->call('content/info-category/get-children', $params);
		$this->view->categories = $response->data;

		//id不为空时候，根据id获取该鱼类的信息
		if($params['id']){//鱼类疾病详情
			
			//取得文章内容
			$response = $this->api->call('content/info/get-item', $params);
			
			$this->view->info = $response->data->info;
			// print_r($this->view->info);

			$this->view->id = $params['id'];
			
			// $params['name']=$this->view->info->title;//鱼类品种名称
			// $response = $this->api->call('project/production-yield/get-list', $params);
			
		}else{//
			// if($param)
			$params['limit'] = 100;
			$params['published_only'] = 0;
			$params['page'] = $params['page'] ? $params['page'] + 1 : 1;
			//获取category_id下所有的新闻
			
			$response = $this->api->call('content/info/get-list', $params);
			//print_r($response);
			// $this->view->result = $response->data;
			$this->view->result = $response->data;
			$pager = new Pager();
			$this->view->pager = $pager->render([
				'limit' => $params['limit'],
				'total' => $response->data->total
			]);
		}
		

        $this->view->render('content/news/qsmark');
    }

    /**
     * 远程诊断
     */
    public function remoteDiagnosis()
    {
		
		//取得新闻动态的分类
      /*
	    $params = $this->input->getArray();
	
		$params['parentId']=14;//新闻动态

        $response = $this->api->call('content/info-category/get-children', $params);
		$this->view->category = $response->data;

        //$params = $this->input->getArray();
        $params['limit'] = 10;
        $params['published_only'] = 0;
        $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
		//获取category_id下所有的新闻
        $response = $this->api->call('content/info/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
		if(empty($params['category_id'])){
			$this->view->title = '新闻动态';	
		}else{
			
			$this->view->title = $params['name'];
		}
	  */
        $this->view->render('content/news/remotediagnosis');
    }
	
	/**
     * 取得所有的类别
    public function category()
    {
        $params = $this->input->getArray();//取得传递的参数数组
        // $params['limit'] = 10;
        // $params['published_only'] = 0;
        // $params['page'] = $params['page'] ? $params['page'] + 1 : 1;
        $response = $this->api->call('content/info/category', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->title = '新闻动态';
        $this->view->render('content/news/index');
    }
     */

}