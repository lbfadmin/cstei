<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/3/2
 * Time: 下午10:17
 */

namespace Module\Producer\Controller\Statistics;


use Module\Account\Controller\Auth;
use System\Component\Pager\Pager;

/**
 * 管理企业渠道比重
 * Class ChannelWeight
 * @package Module\Producer\Controller\Statistics
 */
class ChannelWeight extends Auth
{

    public function __construct()
    {
        parent::__construct();
        $this->view->activePath = 'producer/statistics/channel-weight/index';
    }

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'PRODUCER_STATISTICS_CHANNEL_WEIGHT'
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
            $data['unit_id'] = $_SESSION['user']->unit_id;  //试验站
            $data['time_created'] = date('Y-m-d H:i:s');    //创建时间
            
            $data["standard"]['unit_id'] = $_SESSION['user']->unit_id;   //试验站
            $data["standard"]['time_created'] = $data['time_created'];   //创建时间
            $data["standard"]['quarter'] = $data['quarter']; //季度
            $data["standard"]['type'] = 1;   //标准规格
            
            $data["exceeding"]['unit_id'] = $_SESSION['user']->unit_id; //试验站
            $data["exceeding"]['time_created'] = $data['time_created']; //创建时间
            $data["exceeding"]['quarter'] = $data['quarter'];   //季度
            $data["exceeding"]['type'] = 2; //超标准

            $response = $this->api->call('producer/breeding-price/create', $data['standard']);
            $response = $this->api->call('producer/breeding-price/create', $data['exceeding']);

            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/channel-weight/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->refresh();
            }
        }

        $response = $this->api->call('project/production-unit/get-item', [
            'id' => $_SESSION['user']->unit_id
        ]);

        //取得试验站现在养殖的鱼类
        $this->view->cats = json_decode($response->data->production_unit->saltwater_fish);
        
        //取得正在养殖的鱼类数据，按照季度逆序
        $response = $this->api->call('producer/breeding-price/get-list', [
            'unit_id' => $_SESSION['user']->unit_id
        ]);
        $type_arr = array(1=>"标准规格",2=>"超标准");
        $this->view->type_arr = $type_arr;
        
        $this->view->result = $response->data;
		// print_r($this->view->result);
		// exit;
        $this->view->render('producer/statistics/channel-weight/index');
    }

    /**
     * 添加
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->view->render('producer/statistics/channel-weight/form');
        } else {
            $data = $this->input->getArray();
            $response = $this->api->call('project/ProducerChannelWeight/create', $data);
            if ($response->code === 'OK') {
                $this->message->set('添加成功', 'success');
                $this->response->redirect(url('producer/statistics/channel-weight/index'));
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
            $response = $this->api->call('project/ProducerChannelWeight/get-item', [
                'id' => $this->input->getInt('id')
            ]);
            $this->view->item = $response->data->item;
            $this->view->render('producer/statistics/channel-weight/form');
        } else {
            $data = $this->input->getArray();
            $ref = $this->input->getString('ref', '');
            $response = $this->api->call('project/ProducerChannelWeight/update', $data);
            if ($response->code === 'OK') {
                $this->message->set('保存成功', 'success');
                $this->response->redirect(url($ref ?: 'producer/statistics/channel-weight/index'));
            } else {
                $this->message->set($response->message, 'error');
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}