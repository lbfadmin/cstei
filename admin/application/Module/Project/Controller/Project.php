<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-16
 * Time: 下午2:06
 */

namespace Module\Project\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 园区工程管理
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
        $params = $this->input->getArray();
        $params['limit'] = 10;
        if (isset($params['page'])) {
            $params['page'] += 1;
        }
        //公司
        $responsec = $this->api->call('producer/company/get-list');;
        $list_array = array();
        foreach($responsec->data->list as $k=>$v){
            $list_array[$v->id] = $v->name;
        }
        $this->view->company=$list_array;
        $response = $this->api->call('project/project/get-list', $params);
        foreach($response->data->list as $k=>$v)
        {
            $companyresponse=$this->api->call('producer/company/get-item',[
                'id' => $v->company_id
            ]);
            $response->data->list[$k]->company_name = $companyresponse->data->production_unit->name;
        }

        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);

        $this->view->render('project/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('project/form');
        } else {
            $data = $this->input->getArray();
            if (empty($_FILES['pic']) || $_FILES['pic']['error']) {
                $this->message->set('未选择缩略图', 'error');
                $this->response->refresh();
            }
            $file['pic'] = new \CURLFile($_FILES['pic']['tmp_name'], null, 'pic');
            $response = $this->api->call('common/image/upload', $file);
            $data['pic'] = $response->data->key;
            $response = $this->api->call('project/project/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('project/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }

}