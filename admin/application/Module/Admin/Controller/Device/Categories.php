<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/2/19
 * Time: 下午7:28
 */

namespace Module\Producer\Controller\Storage;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 仓储环境管理
 * Class WarehouseEnv
 * @package Module\Producer\Controller\Storage
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
            // 分类
            // $response = $this->api->call('content/info-category/get-tree');
            // $this->view->categories = $response->data->children;
            // $this->view->render('content/info/info/form');
			
			$data = $_POST;
			// print_r(json_encode($data));
			
			// $params['data'] = json_encode($data);
			// $response = $this->api->call('project/product-type-category/get-all', $params);
			
            // $data = array();
			$data['id'] = $_SESSION['user']->unit_id;
			// $data['saltwater_fish'] = $_SESSION['user']->unit_id;
			
			// print_r($data);
			// exit;
            // $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/production-unit/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                // $this->response->redirect(url($ref ?: 'producer/company/company/index'));
            } else {
                $this->message->set($response->message, 'error');
                // $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
			// exit;
			// 数组转换为json格式保存
        }
			
        $params = $this->input->getArray();
		
		
		
//获取全部的海水鱼分类
//$params['limit'] = 20;
		$response = $this->api->call('project/product-type-category/get-all', $params);
				
		//print_r($this->view->result->list);
		$list_array = array();
		foreach($response->data->list as $k=>$v){

			if($v->parent_id){
			//print_r($v);
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
		
		

		$response = $this->api->call('project/production-unit/get-item', [
			'id' => $_SESSION['user']->unit_id
		]);

		if($response->data->production_unit->saltwater_fish){
			$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		}else{
			$this->view->cats = array();
		}
// print_r($this->view->cats);
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
        $this->view->render('producer/warehouse-env/index');
    }
}