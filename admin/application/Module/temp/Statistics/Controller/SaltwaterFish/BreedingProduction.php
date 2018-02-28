<?php
/**
 * Created by PhpStorm.
 * User: leio
 * Date: 2017/11/11
 * Time: 下午7:28
 */

namespace Module\Statistics\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;
use Module\Account\Model\UserRoleModel;
use PHPExcel_IOFactory;
use PHPExcel;

/**
 * 海水养殖产量统计 
 * Class Power
 * @package Module\Statistics\Controller\SaltwaterFish
 */
class BreedingProduction extends Auth
{


	var $quarter = array();
    public function __construct($args = array()) {
        parent::__construct($args);
		$this->quarter = array(
		"201701"=>"2017年1季度",
		"201702"=>"2017年2季度",
		"201703"=>"2017年3季度",
		"201704"=>"2017年4季度");
		//导入第三方类库
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/IWriter.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel5.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
		require ROOT . '/vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';
    }
    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_CULTURE_OUTPUT'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
		$this->view->quarter = $this->quarter;
		
        $params = $this->input->getArray();
		$response = $this->api->call('producer/breeding-production/get-sum', $params);
		foreach($response->data->list as $k=>$v){
			$response->data->list[$k]->quarter_name = $this->quarter[$v->quarter];
		}
		$this->view->result = $response->data;
	
		$this->view->search = $params;
        $this->view->render('statistics/breeding/production');

		// exit;
		
    }
	//导出方法
    public function push(){
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        $objPHPExcel = new PHPExcel();
        

        
        /*以下是一些设置 ，什么作者 标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("Administrator")
        ->setLastModifiedBy("Administrator")
        ->setTitle("")
        ->setSubject("")
        ->setDescription("海水养殖产量")
        ->setKeywords("excel")
        ->setCategory("result file");
        
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//设置所有格居中显示
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//单个单元格居左
        //$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);//设置单元格自动宽度
 
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 		
        $objPHPExcel->getActiveSheet()->MergeCells("A1:A2"); //合并单元格
        $objPHPExcel->getActiveSheet()->MergeCells("B1:C1"); //合并单元格
        $objPHPExcel->getActiveSheet()->MergeCells("D1:E1:F1"); //合并单元格
        $objPHPExcel->getActiveSheet()->MergeCells("G1:H1"); //合并单元格
        
        
        /*以下就是对处理Excel里的数据*/
        
        //查询数据库中的数据 ？？？？？

        $this->view->quarter = $this->quarter;  //传参导出指定季度
        $params = $this->input->getArray();
		$params['limit']= 9999;
        $response = $this->api->call('producer/breeding-production/get-sum', $params);
        foreach($response->data->list as $k=>$v){
			
            $num=$k+3;  //*设置数据从第几行输入   

            // var_dump($v);
            // echo "<br>\n";	     
            
            $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，id是你查出数组的键值，下面以此类推
            //先设置标题行
             ->setCellValue('A1', '季度')
             ->setCellValue('B1', '池塘养殖（亩）')
			 ->setCellValue('B2', '普通池塘养殖')
             ->setCellValue('C2', '工程化池塘养殖')
             ->setCellValue('D1', '网箱养殖（平方米/立方米）')
             ->setCellValue('D2', '普通网箱养殖')
             ->setCellValue('E2', '深水网箱养殖')
			 ->setCellValue('F2', '围网养殖')
			 ->setCellValue('G1', '工厂化养殖（平方米/立方米）')
             ->setCellValue('G2', '流水养殖')
             ->setCellValue('H2', '循环水养殖')
			 
             
            
             //填充数据/            
             ->setCellValue('A'.$num, $this->quarter[$v->quarter])
             ->setCellValue('B'.$num, $v->普通池塘养殖)
             ->setCellValue('C'.$num, $v->工程化池塘养殖)
             ->setCellValue('D'.$num, $v->普通网箱养殖)
			 ->setCellValue('E'.$num, $v->深水网箱养殖)
			 ->setCellValue('F'.$num, $v->围网养殖)
			 ->setCellValue('G'.$num, $v->流水养殖)
             ->setCellValue('H'.$num, $v->循环水养殖);
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('海水养殖产量');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.'海水养殖产量统计表'.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

        
      
	}
}