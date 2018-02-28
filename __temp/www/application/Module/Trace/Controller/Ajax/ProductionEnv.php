<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2016/12/29
 * Time: 下午9:57
 */

namespace Module\Trace\Controller\Ajax;


use Module\Account\Controller\Ajax;

/**
 * 养殖环境
 * Class ProductionEnv
 * @package Module\Trace\Controller\Ajax
 */
class ProductionEnv extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'FARMING_ENV_MANAGE'
        ];
    }

    /**
     * 获取列表
     */
    public function getList()
    {
        $params = $this->input->getArray();
        $params['limit'] = 20;
        $response = $this->api->call('project/production-env/get-list', $params);
        $this->export($response);
    }

	public function industry()
    {
        $response = $this->api->call('statistic/platform-company/get-list-latest', [
            // 'date_start' => date('Y-01-01'),
            // 'limit' => 12
        ]);
	
        $this->export($response);
    }
    /**
     * 获取全部
     */
    public function getAll()
    {
        $params = $this->input->getArray();
        $params['limit'] = 10000;
        $response = $this->api->call('project/production-env/get-list', $params);
        $this->export($response);
    }
	
		/**
     * 市场经济
     */
    public function marketEconomy()
    {
        $params = $this->input->getArray();
			$params['pool_id'] = $params['id'];
			$params['limit'] = 20;
			// $pager = new Pager();
			// $this->view->pager = $pager->render([
			// 'limit' => $params['limit'],
			// 'total' => $response->data->total
			// ]);
			// //点击鱼类时候，获取最近的鱼类的市场行情 20条
			$response = $this->api->call('/project/production-env/get-list', $params);

			// // $this->view->result = $response->data;
			$this->export($response);
		// }
	
    }
    /**
     * 产业动态数据
     */
    public function industryDynamics()
    {

        $params = $this->input->getArray();
        $response = $this->api->call('statistic/platform-finance/get-list', $params );
        $this->export($response);
    }
}