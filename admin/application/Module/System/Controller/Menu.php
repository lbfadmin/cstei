<?php

namespace Module\System\Controller;

use Application\Component\Util\Tree;
use Module\Account\Controller\Auth;
use Module\System\Model\MenuModel;
use Module\System\Model\ModuleModel;

/**
 * 菜单管理
 * Class Menu
 * @package Module\System\Controller
 */
class Menu extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return array(
            '__ALL__' => 'SYSTEM_MENU_MANAGE',
        );
    }

    /**
     * @path 首页
     */
    public function index()
    {
        $model = new MenuModel();
        $items = $model->getAll();
	
        $comTree = new Tree();
        $comTree->setOptions(array(
            'primaryKey' => 'name',
            'parentKey' => 'parent'
        ));
        $items = $comTree->setData($items)->get();	

        $moduleIds = array();
        foreach ($items as $v) {
            $moduleIds[$v->moduleId] = true;
        }
        $moduleModel = new ModuleModel();
        $modules = $moduleModel->getItems(array(
            'ids' => array_keys($moduleIds)
        ));
		// print_r($items);
		// exit;
        $this->view->menus = $items;
        $this->view->modules = $modules;
        $this->view->render('system/menu/index');
    }

}