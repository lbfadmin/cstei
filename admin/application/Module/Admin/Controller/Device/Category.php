<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 仓储环境管理
 * Class WarehouseEnv
 * @package Module\Producer\Controller\SaltwaterFish
 */
class Category extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_SALTWATERFISH_CATEGORIES'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        if (!empty($_POST)) {
			// $this->view->render('content/info/info/form');
			
			$data = $_POST;//$this->input->getArray();
			// $data['id'] = $_SESSION['user']->unit_id;
	
		// print_r($data);
		// exit;
            $response = $this->api->call('producer/company/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
				$this->response->redirect(url($ref ?: 'producer/company/company-sample/index'));
				
                // $this->response->redirect(url($ref ?: 'producer/company/company/index'));
            } else {
                $this->message->set($response->message, 'error');
                // $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
			// exit;
			// 数组转换为json格式保存
        }
			
        $params = $this->input->getArray();
		$this->view->id = $params['id'];

		//获取全部的海水鱼分类
		$response = $this->api->call('project/product-type-category/get-all', $params);

		$list_array = array();
		foreach($response->data->list as $k=>$v){

			if($v->parent_id){
				if($list_array[$v->parent_id]->list){

				}else{
					$list_array[$v->parent_id]->list = array();
				}
				$list_array[$v->parent_id]->list[$v->id] = $v;

			}else{

				$list_array[$v->id] = $v;
			}
		}
		$this->view->result = $list_array;

		$response = $this->api->call('producer/company/get-item', [
			'id' => $params['id']
			// 'id' => $_SESSION['user']->unit_id
		]);
		
		// print_r($item);
		// exit;
		$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		if($response->data->production_unit->saltwater_fish){
			$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		}else{
			$this->view->cats = array();
		}

        $this->view->render('saltwaterFish/category/index');

// exit;
//获取已经选择的海水鱼分类
//参数为实验站编号
// $_SESSION['user'] 登录用户信息
// $params['unit_id'] = $_SESSION['user']->unit_id;
// $response = $this->api->call('project/product-type-category/get-all', $params);
    

/*
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->operations = [
            1 => '正常',
            2 => '异常'
        ];
*/
    }
}