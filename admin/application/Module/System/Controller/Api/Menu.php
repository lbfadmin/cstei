<?php

namespace Module\System\Controller\Api;

use Application\Component\Util\Tree;
use Module\Account\Controller\Api;
use Module\System\Model\ModuleModel;

/**
 * 菜单接口
 * Class Menu
 * @package Module\System\Controller\Api
 */
class Menu extends Api
{

    /**
     * 获取菜单树
     * @param array $args
     * @return mixed
     */
    public function getTree($args = array())
    {
        $parent = $args['parent'] ?: '';
        $model = new ModuleModel();
        $comTree = new Tree();
        $comTree->setOptions(array(
            'primaryKey' => 'name',
            'parentKey' => 'parent'
        ));
        $menus = $model->getAllMenus();
	// print_r()
        // 去掉无权限的菜单
        foreach ($menus as $k => $v) {	
            if (!$this->permission->check($v->permission)) {	
                unset($menus[$k]);
            }
        }
	
	// print_r("<div style='display:none;'>");
	// print_r($menus);
	// print_r("</div>");
// exit;
        $list = $comTree->setData($menus)->get($parent);
        $this->trimEmpty($list);
        return $this->export(array('content' => $list));
    }

    /**
     * 去掉子项为空且无url的项
     */
    private function trimEmpty(& $list)
    {
        foreach ($list as $k => $v) {
            if (!$v->url && !$v->children) {
                unset($list[$k]);
            }
            if ($v->children) {
                $this->trimEmpty($v->children);
            }
        }
    }
}