<?php
namespace Module\Account\Controller{
use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

 class Fun{

	public function excelColums(){
		return array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T");
	}
	
	/*
	调用方式：
		$var = new \Module\Account\Controller\Fun();
		$columns = array();//列
		$data = $var->dataGroup($response->data->list, $keys, $columns);//多维数组数据
	*/
	public function dataGroup($data, $keys, &$columns){
		$rtn = array();
		// $column_names = array();
		if($data){
			foreach($data[0] as $k=>$v){
				$columns[]=$k;
			}
		}
		// print_r($columns);
		// exit;
		foreach($data as $item){
			$v = (array)$item;

			$key = "";
			foreach($keys as $k) {
				$key = $key.$v[$k];
			}
			$rtn[$key]['data'][]=$v;
			if(!$rtn[$key]['count']) $rtn[$key]['count']=0;
			$rtn[$key]['count']++;
		}
		return $rtn;
	}
	
	
	 
	
	 
	public function getFishArray($api, $unit_id) {

		if(!empty($unit_id)){
			//unit_id是试验站的场合
			$response = $api->call('producer/company-sample/get-item', [
				'id' => $unit_id//$_SESSION['user']->unit_id
			]);

			$parent_id = $response->data->production_unit->parent_id;
			if($parent_id){
				$unit_name = $response->data->production_unit->name;
				$unit_id = $response->data->production_unit->id;
				
				$response = $api->call('producer/company-sample/get-item', [
					'id' => $parent_id//$_SESSION['user']->unit_id
				]);
			}
			return json_decode($response->data->production_unit->saltwater_fish);
		}else{
			//取得全部的水产养殖鱼类
				$response = $api->call('producer/breeding-category/get-all');
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
	}
	 
	 // public function check_username(){
		// echo "regist had saved<br>";
	 // }
 }
}
/*

 function getFishArray($api, $unit_id) {
		// var_dump(new \Application\Component\Util\Api);
		// exit;
		
		// $api = new \Application\Component\Util\Api;
		if(!empty($unit_id)){
			//unit_id是试验站的场合
			$response = $api->call('producer/company-sample/get-item', [
				// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
				'id' => $unit_id//$_SESSION['user']->unit_id
			]);

			$parent_id = $response->data->production_unit->parent_id;
			if($parent_id){
				$unit_name = $response->data->production_unit->name;
				$unit_id = $response->data->production_unit->id;
				
				$response = $api->call('producer/company-sample/get-item', [
					// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
					'id' => $parent_id//$_SESSION['user']->unit_id
				]);
			}
			return json_decode($response->data->production_unit->saltwater_fish);
		}else{
			//取得全部的水产养殖鱼类
				$response = $api->call('project/product-type-category/get-all');
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
 }


	function getFishArray($unit_id){

		if(!empty($unit_id)){
			//unit_id是试验站的场合
			$response = $api->call('producer/company-sample/get-item', [
				// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
				'id' => $unit_id//$_SESSION['user']->unit_id
			]);

			$parent_id = $response->data->production_unit->parent_id;
			if($parent_id){
				$unit_name = $response->data->production_unit->name;
				$unit_id = $response->data->production_unit->id;
				
				$response = $api->call('producer/company-sample/get-item', [
					// 'id' => $data['unit_id']//$_SESSION['user']->unit_id
					'id' => $parent_id//$_SESSION['user']->unit_id
				]);
			}
			return json_decode($response->data->production_unit->saltwater_fish);
		}else{
			//取得全部的水产养殖鱼类
				$response = $api->call('project/product-type-category/get-all');
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
	}
*/
