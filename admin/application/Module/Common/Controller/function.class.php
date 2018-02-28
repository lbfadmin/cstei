<?php
namespace Application\Common\Fun{
	// use 
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
				// ]);
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
	}
}
