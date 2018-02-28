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

class Controller extends Ajax
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
	


$uploaddir = dirname(ROOT)."/files/";//设置文件保存目录 注意包含/  
echo $uploaddir;     
$type=array("jpg","gif","bmp","jpeg","png");//设置允许上传文件的类型   

 
$a=strtolower($this->fileext($_FILES['upfile']['name'])); 

  //判断文件类型   
   if(!in_array(strtolower($this->fileext($_FILES['upfile']['name'])),$type))   
     {   
        $text=implode(",",$type);   
        echo "您只能上传以下类型文件: ",$text,"<br>";   
     }   
   //生成目标文件的文件名       
   else{   
		$filename=explode(".",$_FILES['upfile']['name']);   
        do   
        {   
            $filename[0]=$this->random(10); //设置随机数长度   
            $name=implode(".",$filename);   
            //$name1=$name.".Mcncc";   
            $uploadfile=$uploaddir.$name;   
        }   
	   while(file_exists($uploadfile));   
	   // print_r($uploadfile);
			if (move_uploaded_file($_FILES['upfile']['tmp_name'],$uploadfile)){   
				$data['picture'] = $name;
	
			}   
	   }   


	}
}