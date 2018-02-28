<?php

namespace Module\System\Controller;

use Application\Component\Util\Tree;
use Module\Account\Controller\Auth;
use Module\System\Model\ModuleModel;
use Module\System\Model\PermissionModel;
use Module\System\Model\RoleModel;
use Module\System\Model\RolePermissionModel;

/**
 * 角色权限
 * Class RolePermission
 * @package Module\System\Controller
 */
class RolePermission extends Auth
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return array(
            '__ALL__' => 'SYSTEM_ROLE_MANAGE',
        );
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $roleId = $_REQUEST['roleId'];
        if (!$roleId) {
            $this->error('缺少角色ID');
        }
        $modelRolePermission = new RolePermissionModel();
        $rolePerms = $modelRolePermission->getAll([
            'roleId' => $roleId,
            'key' => 'permission'
        ]);
        if (!$_POST) {
            $modelModule = new ModuleModel();
            $modelRole = new RoleModel();
            $modelPermission = new PermissionModel();
            $modulesList = $modelModule->getItemList([
                'fields' => 'id,name,title'
            ]);
            $permissions = $modelPermission->getAll();
            $permList = $modules = [];
            foreach ($modulesList as & $item) {
                $modules[$item->id] = &$item;
            }
            foreach ($permissions as & $item) {
                $permList[$item->moduleId][] = &$item;
            }
            $tree = new Tree();
            $tree->setOptions([
                'primaryKey' => 'name',
                'parentKey' => 'parent'
            ]);
            $treeList = [];
            foreach ($permList as $k => $value) {
                $tree->setData($value);
                $treeList[$k] = $tree->get('');
            }
            $role = $modelRole->getItem([
                'id' => $roleId
            ]);
            $this->view->permList = $treeList;
            $this->view->modules = $modules;
            $this->view->role = $role;
            $this->view->rolePerms = $rolePerms;
            $this->view->activePath = 'system/role/index';
            $this->view->render('system/role/permission');
        } else {
            $data = $_POST;
            $rolePerms = array_keys($rolePerms);
            $adds = array_diff($data['perm'], $rolePerms);
            $deletes = array_diff($rolePerms, $data['perm']);
            try {
                if ($deletes) {
                    $sets = [];
                    foreach ($deletes as & $item) {
                        $sets[] = "'{$item}'";
                    }
                    $modelRolePermission->delete(
                        ['permission IN(' . implode(',', $sets) . ')'],
                        [], null
                    );
                }
                if ($adds) {
                    $new = [];
                    foreach ($adds as $v) {
                        $new[] = [
                            'roleId' => $roleId,
                            'permission' => $v
                        ];
                    }
                    $modelRolePermission->add($new);
                }
                $this->message->set('保存成功', 'info');
            } catch (\Exception $e) {
                $this->message->set('保存失败', 'error');
                $this->message->set($this->db->sth->errorInfo()[2], 'error');
            }
            $this->response->redirect(url('system/role/index'));
        }
    }

}