<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-8
 * Time: 下午4:42
 */

namespace Module\Content\Controller\Ajax;


use Application\Controller\Front;
use System\Component\Pager\Pager;

/**
 * 新闻资讯
 * Class News
 * @package Module\Content\Controller
 */
class Industry extends Front
{

    /**
     * 详情
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
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
     * 新闻动态
     */
    public function getList()
    {
		
		$response = $this->api->call('statistic/platform-company/get-list', [
		'date_start' => date('Y-01-01'),
		'limit' => 12
        ]);
		print_r($response);
		exit;
        // $this->export($response);
    }
	

}