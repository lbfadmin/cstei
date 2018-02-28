<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-4-17
 * Time: 下午3:53
 */

namespace Module\Statistic\Controller;


use Application\Controller\Api;
use Module\Statistic\Model\StatisticPlatformFinanceModel;
use Module\Project\Model\ProductTypeCategoryModel;

/**
 * 平台财务统计
 * Class PlatformFinance
 * @package Module\Statistic\Controller
 */
class PlatformFinance extends Api
{

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
		// 鱼类的名称
		// 根据鱼类名称获取
        // $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        // $limit = $this->input->getInt('limit', 20);
        $params = [
            'name' => $this->input->getString('name'),
            // 'pager' => [
                // 'page' => $page,
                // 'limit' => $limit
            // ]
        ];

		//根据海水鱼的名称取得ID
		$model = new ProductTypeCategoryModel();
		$data = $model->getItems($params);
		
		foreach($data as $k=>$v){
			$id = $v->id;
			break;
		}
		// print_r($id);
		// exit;
		$params['pool_id'] = $id;
        $model = new StatisticPlatformFinanceModel();
        $result = $model->getList($params);
		// print_r($result);
		// exit;
        return $this->export([
            'data' => $result
        ]);
    }
}