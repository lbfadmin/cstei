<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:17
 */

namespace Module\Statistics\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;
use PHPExcel_IOFactory;
use PHPExcel;
/**
 * 季度末海水鱼成鱼塘边现价（单位：元/斤）
 * Class FishPrice
 * @package Module\Statistics\Controller\SaltwaterFish
 */
class AdultFishPrice extends Auth
{
	var $quarter = array();
    public function __construct($args = array()) {
        parent::__construct($args);
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");
        $this->type = array("1"=>"标准规格","2"=>"超标准");
        //导入第三方类库
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/IWriter.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
        $this->view->activePath = 'producer/station/channel-weight/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_SALTWATERFISH_PRICE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
		$this->view->quarter = $this->quarter;
		$params = $this->input->getArray();
		$var = new \Module\Account\Controller\Fun();
		$this->view->cats = $var->getFishArray($this->api, 0);
		$response = $this->api->call('producer/adult-fish-price/get-sum', $params);

		foreach($response->data->list as $k=>$v){
			$response->data->list[$k]->unit_name = $companies[$v->unit_id];
			$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
		}
		$this->view->result = $response->data;

		$this->view->search = $params;
		
		$type_arr = array(1=>"标准规格",2=>"超标准");
		$this->view->type_arr = $type_arr;
        $this->view->render('statistics/saltwaterfish/adult-fish-price/index');
    }

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
	}
 		 	 //导出方法
    public function push(){
		error_reporting(E_ALL^E_NOTICE);
        date_default_timezone_set('Europe/London');
        $objPHPExcel = new PHPExcel();
        

        
        /*以下是一些设置 ，什么作者 标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("Administrator")
        ->setLastModifiedBy("Administrator")
        ->setTitle("")
        ->setSubject("")
        ->setDescription("海水鱼成鱼塘边现价（单位：元/斤）")
        ->setKeywords("excel")
        ->setCategory("result file");
        
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置所有格居中显示
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);//设置单元格自动宽度
 
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10); 		
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10); 
        
        
        /*以下就是对处理Excel里的数据*/
        
        //查询数据库中的数据 
		//$this->view->quarter = $this->quarter;
        //取得试验站下面的所有示范县
		//搜索所有的示范县

		
		$this->view->quarter = $this->quarter;
		$params = $this->input->getArray();
		//$params['quarter'] = $data['quarter'];
        $params['limit']= 9999;
		$this->view->cats = $this->getFishArray(0);
		// $response = $this->api->call('producer/breeding-area/get-list', $params);
		$response = $this->api->call('producer/adult-fish-price/get-sum', $params);
		


		//print_r($response);exit;
        foreach($response->data->list as $k=>$v){
            // $response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
            $num=$k+2;  //*设置数据从第几行输入
            // echo "Value:$k<br>\n";
            //var_dump($v);
           // echo "<br>\n";
        
            
            
            
            $objPHPExcel->setActiveSheetIndex(0)
            // Excel的第A列，id是你查出数组的键值，下面以此类推
            // 先设置标题行
             ->setCellValue('A1', '季度')
             ->setCellValue('B1', '规格')
             ->setCellValue('C1', '大菱鲆')
             ->setCellValue('D1', '牙鲆')
             ->setCellValue('E1', '半滑舌鳎')
             ->setCellValue('F1', '大黄鱼')
			 ->setCellValue('G1', '海鲈鱼')
			 ->setCellValue('H1', '河鲀')
			 ->setCellValue('I1', '卵形鲳鲹')
			 ->setCellValue('J1', '军曹鱼')
			 ->setCellValue('K1', '珍珠龙胆')
			 ->setCellValue('L1', '青斑')
			 ->setCellValue('M1', '老虎斑')
			 ->setCellValue('N1', '赤点石斑鱼')
             
            
             // 填充数据/            
             ->setCellValue('A'.$num, $this->quarter[$v->quarter])
             ->setCellValue('B'.$num, $this->type[$v->type])
             ->setCellValue('C'.$num, $v->大菱鲆)
             ->setCellValue('D'.$num, $v->牙鲆)
			 ->setCellValue('E'.$num, $v->半滑舌鳎)
			 ->setCellValue('F'.$num, $v->大黄鱼)
			 ->setCellValue('G'.$num, $v->海鲈鱼)
			 ->setCellValue('H'.$num, $v->其他河鲀鱼)
			 ->setCellValue('I'.$num, $v->卵形鲳鲹)
			 ->setCellValue('J'.$num, $v->军曹鱼)
			 ->setCellValue('K'.$num, $v->珍珠龙胆)
			 ->setCellValue('L'.$num, $v->青斑)
			 ->setCellValue('M'.$num, $v->老虎斑)
             ->setCellValue('N'.$num, $v->赤点石斑鱼);
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('海水鱼成鱼塘边现价');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.'海水鱼成鱼塘边现价（单位：元/斤）统计表'.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
       
	
    }
 
}