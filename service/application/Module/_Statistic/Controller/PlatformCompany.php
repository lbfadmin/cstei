<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-4-17
 * Time: 下午3:20
 */

namespace Module\Statistic\Controller;


use Application\Controller\Api;
use Module\Statistic\Model\StatisticPlatformCompanyModel;

/**
 * 平台企业统计
 * Class PlatformCompany
 * @package Module\Statistic\Controller
 */
class PlatformCompany extends Api
{

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $limit = $this->input->getInt('limit', 20);
        $model = new StatisticPlatformCompanyModel();
        $params = [
            'date_start' => $this->input->getString('date_start'),
            'date_end' => $this->input->getString('date_end'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $model->getList($params);
        return $this->export([
            'data' => $result
        ]);
    }
	
    /**
     * 获取列表
     * @return mixed
     */
    public function getListLatest()
    {
        // $page = $this->input->getInt('page', 1);
        // $page = $page > 0 ? $page - 1 : 0;
        // $limit = $this->input->getInt('limit', 20);
        $model = new StatisticPlatformCompanyModel();
        $params = [
            // 'date_start' => $this->input->getString('date_start'),
            // 'date_end' => $this->input->getString('date_end'),
            // 'pager' => [
                // 'page' => $page,
                // 'limit' => $limit
            // ]
        ];
        $result = $model->getListLatest($params);
        return $this->export([
            'data' => $result
        ]);
    }
}