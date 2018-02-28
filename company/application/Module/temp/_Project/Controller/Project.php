<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-16
 * Time: 下午2:06
 */

namespace Module\Project\Controller;


use Module\Account\Controller\Auth;

/**
 * 管理项目
 * Class Project
 * @package Module\Project\Controller
 */
class Project extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PROJECT_PROJECT_MANAGE'
        ];
    }

    /**
     * 列表
     */
    public function index()
    {		
      if (!empty($_POST)) {
			//保存上传的数据 ，空默认为0
            $data = $this->input->getArray();
			$data['unit_id'] = $_SESSION['user']->unit_id;	//试验站
			$data['time_created'] = date('Y-m-d H:i:s');	//创建时间
			
            $response = $this->api->call('project/breeding-area_swf/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('project/project/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
		}
	
		$way_arr = array(1=>"工厂化（吨）",2=>"网箱（吨）",3=>"池塘（吨）");
		$this->view->way_arr = $way_arr;
		
		//取得当前试验站养殖的鱼类
		$response = $this->api->call('project/production-unit/get-item', [
			'id' => $_SESSION['user']->unit_id
		]);
		$this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
		
		
		//取得当前试验站的养殖面积
		
		$response = $this->api->call('project/breeding-area-swf/get-list', [
			'unit_id' => $_SESSION['user']->unit_id
		]);
		$this->view->result = $response->data;
		// print_r($response->data->list);
		// exit;
        $this->view->render('project/project/index');
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
            $data = $this->input->getArray();
            if (empty($_FILES['picture']) || $_FILES['picture']['error']) {
                $this->message->set('未选择缩略图', 'error');
                $this->response->refresh();
            }
            $file['picture'] = new \CURLFile($_FILES['picture']['tmp_name'], null, 'picture');
            $response = $this->api->call('common/image/upload', $file);
            $data['picture'] = $response->data->key;
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

}