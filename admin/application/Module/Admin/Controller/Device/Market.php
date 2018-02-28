<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:18
 */

namespace Module\Producer\Controller\SaltwaterFish;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理行情预估报告
 * Class Market
 * @package Module\Producer\Controller\SaltwaterFish
 */
class Market extends Auth
{
    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'producer/statistics/market/index';
    }

    public function index()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/ProducerMarket/get-list', $params);
        $this->view->result = $response->data;
        $pager = new Pager();
        $this->view->pager = $pager->render([
            'limit' => $params['limit'],
            'total' => $response->data->total
        ]);
        $this->view->render('producer/statistics/market/index');
    }

    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('producer/statistics/market/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/ProducerMarket/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/market/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }
    }

    public function edit()
    {
        if (empty($_POST)) {
            $response = $this->api->call('project/ProducerMarket/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('producer/statistics/market/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/ProducerMarket/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/statistics/market/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}