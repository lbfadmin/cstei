<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午10:26
 */

namespace Module\System\Controller\Ajax;


use Module\Account\Controller\Ajax;
use Module\System\Model\MenuModel;
use Module\System\Model\ModuleModel;
use Module\System\Model\PermissionModel;
use System\Bootstrap;
use System\Loader;

/**
 * 模块ajax
 * Class Module
 * @package Module\System\Controller\Ajax
 */
class Module extends Ajax
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
     * 安装模块
     */
    public function install()
    {
        if (! $_POST) {
            $this->view->activePath = 'system/module/index';
            $this->view->render('system/module/install');
        } else {
            $modelModule = new ModuleModel();
            $modelMenu   = new MenuModel();
            $modelPerm   = new PermissionModel();

            $path = Bootstrap::formatPath($_POST['path']);
            $prefix = "Module\\{$path}";
            $config = Loader::load("{$prefix}\\Config\\module");
            $menu  = $config['menu'];
            $perm  = $config['permission'];
            $info  = $config['info'];

            if (! $config) {
                return $this->export([
                    'code' => 'MODULE_NOT_FOUND',
                    'message' => '没有这个模块，请检查安装路径'
                ]);
            }
            $module = $modelModule->getItem(array(
                'name' => $info['name']
            ));
            if ($module) {
                return $this->export([
                    'code' => 'MODULE_EXISTS',
                    'message' => '模块已存在。'
                ]);
            } else {
                // 添加模块
                $info['path'] = $path;
                $info['author'] = serialize($info['author']);
                $info['timestamp'] = REQUEST_TIME;
                $info['isLocked'] = 1;

                try {
                    $this->db->beginTransaction();
                    $moduleId = $modelModule->add($info);
                    if (!empty($menu)) {
                        $modelMenu->addItems($moduleId, $menu);
                    }
                    if (!empty($perm)) {
                        $modelPerm->addItems($moduleId, $perm);
                    }
                    $this->db->commit();
                } catch (\Exception $e) {
                    $this->db->rollBack();
                    return $this->export([
                        'code' => self::STATUS_SYS_ERROR,
                        'message' => '模块安装失败:' . $e->getMessage()
                    ]);
                }
                return $this->export([
                    'message' => '模块安装成功'
                ]);
            }
        }
    }
}