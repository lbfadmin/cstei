<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:17
 */

namespace Module\Statistics\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
// use Module\Account\Controller\Fun;
// use Module\Account\Controller as Common;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;
use PHPExcel_IOFactory;
use PHPExcel;

/**
 * 本季度示范区县海水鱼成鱼养殖产量统计
 * Class AdultFishProduction
 * @package Module\Statistics\Controller\SaltwaterFish
 */
class AdultFishProduction extends Auth
{
	var $quarter = array();
    public function __construct($args = array()) {
        parent::__construct($args);

		
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");
		$this->types = array(
	    "1"=>"本季销售量（吨）",
	    "2"=>"本季末存量 待养成鱼（万尾）",
	    "3"=>"本季末存量 待养成鱼（吨）",
	    "4"=>"本季末存量 商品鱼（万尾）",
	    "5"=>"本季末存量 商品鱼（吨）");	
		$this->ways = array(
		"1"=>"工厂化（吨）",
		"2"=>"网箱（吨）",
		"3"=>"池塘（吨）");		
		//导入第三方类库
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/IWriter.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

        // $this->view->activePath = 'producer/statistics/annual-trend/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_ADULTFISH_PRODUCTION'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
		$var = new \Module\Account\Controller\Fun();
		$this->view->cats = $var->getFishArray($this->api, 0);

		$this->view->quarter = $this->quarter;
		$params = $this->input->getArray();

		$response = $this->api->call('producer/adult-fish-production/get-sum', $params);

		foreach($response->data->list as $k=>$v){
			// $response->data->list[$k]->unit_name = $companies[$v->unit_id];
			$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
		}
		$this->view->result = $response->data;
		
		$this->view->search = $params;

		$type_arr = array(
			1=>"本季销售量（吨）"
			,2=>"本季末存量 待养成鱼（万尾）"
			,3=>"本季末存量 待养成鱼（吨）"
			,4=>"本季末存量 商品鱼（万尾）"
			,5=>"本季末存量 商品鱼（吨）");
		$this->view->type_arr = $type_arr;
		
		$way_arr = array(
			1=>"工厂化（吨）",
			2=>"网箱（吨）",
			3=>"池塘（吨）");
		$this->view->way_arr = $way_arr;
		$this->view->result = $response->data;
        $this->view->render('statistics/saltwaterfish/adult-fish-production/index');
	
    }
	  	 //导出方法
    public function push(){
		// error_reporting(E_ALL^E_NOTICE);
        // date_default_timezone_set('Europe/London');
        $objPHPExcel = new PHPExcel();
        

        
        /*以下是一些设置 ，什么作者 标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("Administrator")
        ->setLastModifiedBy("Administrator")
        ->setTitle("")
        ->setSubject("")
        ->setDescription("海水鱼成鱼养殖产量")
        ->setKeywords("excel")
        ->setCategory("result file");
        
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置所有格居中显示
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);//设置单元格自动宽度
 
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20); 		
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);		
        
        
        /*以下就是对处理Excel里的数据*/
        
        //查询数据库中的数据 

		$this->view->quarter = $this->quarter;
		$params = $this->input->getArray();
        $params['limit']= 9999;
		$this->view->cats = $this->getFishArray(0);
		$response = $this->api->call('producer/adult-fish-production/get-sum', $params);
		
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
             ->setCellValue('B1', '养殖方式')
			 ->setCellValue('C1', '规格')
             ->setCellValue('D1', '大菱鲆')
             ->setCellValue('E1', '牙鲆')
             ->setCellValue('F1', '半滑舌鳎')
             ->setCellValue('G1', '大黄鱼')
			 ->setCellValue('H1', '海鲈鱼')
			 ->setCellValue('I1', '河鲀')
			 ->setCellValue('J1', '卵形鲳鲹')
			 ->setCellValue('K1', '军曹鱼')
			 ->setCellValue('L1', '珍珠龙胆')
			 ->setCellValue('M1', '青斑')
			 ->setCellValue('N1', '老虎斑')
			 ->setCellValue('O1', '赤点石斑鱼')
             
            
             // 填充数据/            
             ->setCellValue('A'.$num, $this->quarter[$v->quarter])
             ->setCellValue('B'.$num, $this->ways[$v->way_id])
			 ->setCellValue('C'.$num, $this->types[$v->type])
             ->setCellValue('D'.$num, $v->大菱鲆)
             ->setCellValue('E'.$num, $v->牙鲆)
			 ->setCellValue('F'.$num, $v->半滑舌鳎)
			 ->setCellValue('G'.$num, $v->大黄鱼)
			 ->setCellValue('H'.$num, $v->海鲈鱼)
			 ->setCellValue('I'.$num, $v->其他河鲀鱼)
			 ->setCellValue('J'.$num, $v->卵形鲳鲹)
			 ->setCellValue('K'.$num, $v->军曹鱼)
			 ->setCellValue('L'.$num, $v->珍珠龙胆)
			 ->setCellValue('M'.$num, $v->青斑)
			 ->setCellValue('N'.$num, $v->老虎斑)
             ->setCellValue('O'.$num, $v->赤点石斑鱼);
        }
      
        $objPHPExcel->getActiveSheet()->setTitle('海水鱼成鱼养殖产量');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.'示范区县海水鱼成鱼养殖产量统计表'.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
      
    }
}