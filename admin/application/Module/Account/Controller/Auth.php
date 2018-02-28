<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-4-18
 * Time: 下午4:52
 */

namespace Module\Account\Controller;


use Application\Controller\Front;

class Auth extends Front
{

    /**
     * 忽略认证的action
     * @var array
     */
    protected $ignoreAuth = array();

    /**
     * 权限
     * @var array
     */
    protected $permissions = [];

    public function __construct()
    {
        parent::__construct();

        $action = $this->thread->getAction();
        if (! in_array($action, $this->ignoreAuth) && ! $this->auth->isLogin()) {

            $ref = $this->request->href();

            $this->response->redirect(url('account/login', ['query' => ['ref' => $ref]]));
        }
        // 检查权限
        if (method_exists($this, 'permission')) {
            $perms = $this->permission();
            $this->permissions = array_merge($this->permissions, $perms);
	
		// print_r($perms);
		// exit;
            $action = $this->thread->getAction();
            if (isset($this->permissions['__ALL__'])) {
                $action = '__ALL__';
            }
            if (isset($this->permissions[$action])) {
				
				// print_r($this->permissions[$action]);
                $result = $this->permission->check($this->permissions[$action]);
				// print_r($result);
				// exit;
                if (! $result) {
                    $this->error('您没有权限进行此操作', 403);
                }
            }
        }
    }
	
/*	// use 
	function getFishArray($unit_id){

		if(!empty($unit_id)){
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
			return json_decode($response->data->production_unit->saltwater_fish);
		}else{
			//取得全部的水产养殖鱼类
				$response = $this->api->call('project/product-type-category/get-all');
				$list_array = array();
				foreach($response->data->list as $k=>$v){
					if($v->parent_id){
						if($list_array[$v->parent_id]) unset($list_array[$v->parent_id]);
						$list_array[$v->id] = $v->name;
					}else{
						$list_array[$v->id] = $v->name;
					}
				}	
			return $list_array;
		}
	}*/
}