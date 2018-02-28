<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-2
 * Time: 上午11:22
 */

namespace Module\Home\Controller\Ajax;


use Application\Controller\Ajax;

/**
 * 水质数据ajax
 * Class WaterQuality
 * @package Module\Home\Controller\Ajax
 */
class WaterQuality extends Ajax
{

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $response = $this->api->call('supervisor/water-quality/get-list', [
            'monitoring_point_id' => $this->input->getInt('point_id')
        ]);
        $list = $response->data->list;
        $group = [];
        if (!empty($list)) {
            foreach ($list as $item) {
                $group['temp'][] = ['value' => [$item->time_created, $item->shui_wen]];
                $group['ph'][] = ['value' => [$item->time_created, $item->ph]];
                $group['oxy'][] = ['value' => [$item->time_created, $item->rong_yang]];
            }
        }
        return $this->export([
            'data' => [
                'group' => $group
            ]
        ]);
    }
}