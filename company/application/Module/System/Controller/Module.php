<?php

namespace Module\System\Controller;

use Module\Account\Controller\Auth;
use Module\System\Model\MenuModel;
use Module\System\Model\ModuleModel;
use Module\System\Model\PermissionModel;
use System\Bootstrap;
use System\Component\Pager\Pager;
use System\Loader;

/**
 * 模块管理
 * Class Module
 * @package Module\System\Controller
 */
class Module extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return array(
            '__ALL__' => 'SYSTEM_MODULE_MANAGE',
        );
    }

    /**
     * @path 首页
     */
    public function index()
    {
        $model = new ModuleModel();
        $pager = new Pager();
        $pagerParams = array(
            'page' => $pager->getPageNumber(),
            'limit' => 20,
            'total' => $model->count()
        );
        $params['pager'] = $pagerParams;
        $items = $model->getItemList($params);
        $this->view->modules = $items;
        $this->view->render('system/module/index');
    }

    /**
     * 重新加载模块配置
     */
    public function reload()
    {
        $moduleId = (int)$_GET['id'];
        if (!$moduleId) {
            $this->error('缺少模块ID');
        }
        $modelModule = new ModuleModel();
        $modelMenu = new MenuModel();
        $modelPerm = new PermissionModel();

        $module = $modelModule->getItem(array(
            'id' => $moduleId
        ));
        $path = Bootstrap::formatPath($module->path);
        $prefix = "Module\\{$path}";
        $config = Loader::load("{$prefix}\\Config\\module");
        $menu = $config['menu'];
        $perm = $config['permission'];
        $info = $config['info'];

        if (!$config) {
            $this->message->set('配置文件不存在', 'error');
            $this->response->redirect(url('system/module/index'));
        }
        // 模块信息
        $info['path'] = $path;
        $info['author'] = serialize($info['author']);
        $info['timestamp'] = REQUEST_TIME;
        $info['isLocked'] = 1;

        try {
            $this->db->beginTransaction();
            $modelModule->update(
                $info, ['id = ?', [$moduleId]]
            );
            if ($menu) {
                $modelMenu->delete(['moduleId=?', [$moduleId]], [], 0);
                $modelMenu->addItems($moduleId, $menu);
            }
            if ($perm) {
                $modelPerm->delete(['moduleId=?', [$moduleId]], [], 0);
                $modelPerm->addItems($moduleId, $perm);
            }
            $this->db->commit();
            $this->message->set('模块重载成功', 'success');
        } catch (\Exception $e) {
            $this->db->rollBack();
            $this->message->set('模块重载失败，原因：' . $e->getMessage(), 'error');
        }
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * 卸载模块
     */
    public function uninstall()
    {
        $moduleId = $_GET['id'];

        $modelModule = new ModuleModel();
        $modelMenu = new MenuModel();
        $modelPerm = new PermissionModel();

        $module = $modelModule->getItem(array('id' => $moduleId));
        Bootstrap::invokeHook('onModuleUninstall', $module);

        try {
            $this->db->beginTransaction();
            $modelModule->delete(['id=?', [$moduleId]]);
            $modelMenu->delete(['moduleId=?', [$moduleId]], [], 0);
            $modelPerm->delete(['moduleId=?', [$moduleId]], [], 0);
            $this->db->commit();
            $this->message->set('模块卸载成功', 'success');
        } catch (\Exception $e) {
            $this->db->rollBack();
            $this->message->set('模块卸载失败:' . $e->getMessage(), 'error');
        }
        $this->response->redirect('/system/module/index');
    }
}