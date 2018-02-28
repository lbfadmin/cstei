<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-16
 * Time: 下午1:35
 */

namespace Module\Common\Controller\Ajax;


use Module\Account\Controller\Ajax;

class Area extends Ajax
{

    public function getChildren()
    {
        $response = $this->api->call('common/area/get-children', [
            'parent_id' => $this->input->getInt('parent_id')
        ]);
        $this->export($response);
    }
}