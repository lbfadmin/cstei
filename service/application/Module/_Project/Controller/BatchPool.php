<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-6
 * Time: 下午3:13
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\BatchPoolModel;

/**
 * 批次-养殖池
 * Class BatchPool
 * @package Module\Project\Controller
 */
class BatchPool extends Api
{

    /**
     * 养殖池ID获取批次
     * @return mixed
     */
    public function getBatchesByPool()
    {
        $poolId = $this->input->getInt('pool_id');
        $batchPoolModel = new BatchPoolModel();
        $items = $batchPoolModel->getBatchesByPool($poolId);
        return $this->export([
            'data' => [
                'items' => $items
            ]
        ]);
    }
}