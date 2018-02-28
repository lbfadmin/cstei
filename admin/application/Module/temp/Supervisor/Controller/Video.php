<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/8
 * Time: 下午3:21
 */

namespace Module\Supervisor\Controller;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 视频数据
 * Class Video
 * @package Module\Supervisor\Controller
 */
class Video extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SUPERVISOR_VIDEO_MANAGE'
        ];
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('supervisor/video/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('supervisor/video/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('supervisor/video/index'));
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
            $response = $this->api->call('supervisor/video/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->check;
            $this->view->render('supervisor/video/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('supervisor/video/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'supervisor/video/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     * 列表
     */
    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('supervisor/video/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        //获取养殖池
        $response = $this->api->call('project/production-pool/get-all');
        $this->view->pools = $response->data->list;
        $this->view->render('supervisor/video/index');
    }
}