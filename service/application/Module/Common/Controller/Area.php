<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-16
 * Time: 下午1:44
 */

namespace Module\Common\Controller;


use Application\Controller\Api;
use Module\Common\Model\AreaModel;

/**
 * 地区
 * Class Area
 * @package Module\Common\Controller
 */
class Area extends Api
{

    /**
     * 获取子级
     * @return mixed
     */
    public function getChildren()
    {
        $parentId = $this->input->getInt('parent_id', 0);
        $modelArea = new AreaModel();
        try {
            $children = $modelArea->getAll([
                'parent_id' => $parentId,
            ]);
            return $this->export([
                'data' => [
                    'children' => $children
                ]
            ]);
        } catch(\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR
            ]);
        }
    }
}