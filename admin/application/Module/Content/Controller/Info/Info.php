<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-30
 * Time: 上午11:35
 */

namespace Module\Content\Controller\Info;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理资讯
 * Class Info
 * @package Module\Content\Controller\Info
 */
class Info extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'content/info/info/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'CONTENT_INFO_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();

		// 分类
		$response = $this->api->call('content/info-category/get-tree');
		$this->view->categories = $response->data->children;
		
        $params['limit'] = 10;
        // $params['published_only'] = 0;
        // if (!empty($params['created_start'])) {
            // $params['created_start'] = $params['created_start'] . ' 00:00:00';
        // }
        // if (!empty($params['created_end'])) {
            // $params['created_end'] = $params['created_end'] . ' 00:00:00';
        // }
        $response = $this->api->call('content/info/get-list', $params);
        $this->view->result = $response->data;

		// print_r($response);
		// exit;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('content/info/info/index');
    }
	
	
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
	
	function uploadImage(){
			/*允许缩略图为空*/
			if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
			// $this->message->set('未选择缩略图', 'error');
			// $this->response->refresh();
			}else{

			$uploaddir = dirname(ROOT)."/files/";//设置文件保存目录 注意包含/  
			// echo $uploaddir;
			// exit;     
			$type=array("jpg","gif","bmp","jpeg","png");//设置允许上传文件的类型   


			$a=strtolower($this->fileext($_FILES['picture']['name'])); 

			//判断文件类型   
			if(!in_array(strtolower($this->fileext($_FILES['picture']['name'])),$type))   
			{   
				$text=implode(",",$type);   
				echo "您只能上传以下类型文件: ",$text,"<br>";   
			}   
			//生成目标文件的文件名       
			else{   
				$filename=explode(".",$_FILES['picture']['name']);   
				do   
				{   
				$filename[0]=$this->random(10); //设置随机数长度   
				$name=implode(".",$filename);   
				//$name1=$name.".Mcncc";   
				$uploadfile=$uploaddir.$name;   
				}   
				while(file_exists($uploadfile));   
					// print_r($uploadfile);
					if (move_uploaded_file($_FILES['picture']['tmp_name'],$uploadfile)){   
					$data['picture'] = $name;
						// // if(is_uploaded_file($_FILES['file']['tmp_name'])){   
						// if(is_uploaded_file($_FILES['picture']['size'])){   
						// // $_FILES['userfile']['size']
						// //输出图片预览   
						// echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";   
						// echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";   
						// }   
						// else{   
						// // echo "上传失败！";   
						// }   
					}   
				}   
			}  
		return $name;
	}
	
    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            // 分类
            $response = $this->api->call('content/info-category/get-tree');
            $this->view->categories = $response->data->children;
            $this->view->render('content/info/info/form');
        } else {
	
			$data = $_POST;

			$data['picture'] = $this->uploadImage();//上传缩略图
			// print_r($data);
			// exit;

            $response = $this->api->call('content/info/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('content/info/info/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (empty($_POST)) {
            $response = $this->api->call('content/info/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->info;
            // 分类
            $response = $this->api->call('content/info-category/get-tree');
            $this->view->categories = $response->data->children;
            $this->view->render('content/info/info/form');
        } else {
			$data = $_POST;
	
            $ref = $this->input->getString('ref', '');
		
            if (!empty($_FILES['picture']) && !$_FILES['picture']['error']) {
				
                // $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
				// // print_r($_FILES);
				// // exit;
                // $response = $this->api->call('common/image/upload', $file);
				
				$data['picture'] = $this->uploadImage();
                // $data['picture'] = $response->data->key;	
				// print_r($data);
			// exit;
				
            }
            $response = $this->api->call('content/info/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'content/info/info/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}