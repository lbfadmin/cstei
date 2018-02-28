<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-13
 * Time: 下午2:53
 */

namespace Module\Common\Controller\Ajax;


use Module\Account\Controller\Ajax;
use System\Component\File\UploaderClass;
use System\Loader;

class File extends Ajax
{

       //获取文件后缀名函数   
    function fileext($filename)   
    {   
        return substr(strrchr($filename, '.'), 1);   
    }  
   //生成随机文件名函数       
    function random($length)   
    {   
        $hash = 'CR-';   
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';   
        $max = strlen($chars) - 1;   
        mt_srand((double)microtime() * 1000000);   
            for($i = 0; $i < $length; $i++)   
            {   
                $hash .= $chars[mt_rand(0, $max)];   
            }   
        return $hash;   
    }  
	
	public function ueditorUpload()
    {
        $result = null;
        switch ($_REQUEST['action']) {
            case 'config':
                $config = file_get_contents(Loader::find('Application\Config\ueditor', '.json'));
                $config = preg_replace("/\/\*[\s\S]+?\*\//", "", $config);
                $result = json_decode($config, true);
                break;
            case 'uploadimage':
            case 'uploadfile':


$msg = "SUCCESS";
try {
	
$uploaddir = dirname(ROOT)."/files/";//设置文件保存目录 注意包含/  
// echo $uploaddir;
// exit;     
$type=array("jpg","gif","bmp","jpeg","png");//设置允许上传文件的类型   

 
$a=strtolower($this->fileext($_FILES['upfile']['name'])); 

  //判断文件类型   
   if(!in_array(strtolower($this->fileext($_FILES['upfile']['name'])),$type))   
     {   
        $text=implode(",",$type);   
        $msg = "您只能上传以下类型文件"; 
     }   
   // //生成目标文件的文件名       
   else{   
		$filename=explode(".",$_FILES['upfile']['name']);   
        // do   
        // {   
            $filename[0]=$this->random(10); //设置随机数长度   
            $name=implode(".",$filename);   
            //$name1=$name.".Mcncc";   
            $uploadfile=$uploaddir.$name;   
			
        // }   
	   // if(file_exists($uploadfile)){

			if (move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)){   
				$data['upfile'] = $name;
				$msg= $name;
			}   
	   // }   
	}  
	// echo $name;
	// exit;	
} 
catch (Exception $e) {
	$msg = $e->getMessage();
	// exit();
}					
$result = [
'state'    => "SUCCESS",
'url'      => "http://images.marinefish.cn/".$name,
'title'    => $name,
'original' => $name,
'type'     => $a,
// 'size'     => $data->meta->size
];
				break;
                // if ($_FILES && ! current($_FILES)['error']) {
                    // $file = $_FILES['upfile'];
                    // $params['file'] = new \CURLFile($file['tmp_name'], $file['type'], $file['name']);
                    // $params['is_temp'] = 0;
                    // $response = $this->api->call('common/file/upload', $params);
                    // if ($response->code !== 'OK') {
                        // $result = [
                            // 'state' => 'ERROR'
                        // ];
                    // } else {
                        // $data = $response->data;
                        // $result = [
                            // 'state'    => 'SUCCESS',
                            // 'url'      => $data->url,
                            // 'title'    => $data->name,
                            // 'original' => $data->name,
                            // 'type'     => $data->mime,
                            // 'size'     => $data->meta->size
                        // ];
                    // }
                // } else {
                    // $result = [
                        // 'state' => 'ERROR'
                    // ];
                // }
                // break;
        }
        echo json_encode($result);
    }
}