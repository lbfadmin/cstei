<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-5
 * Time: 上午10:38
 */

namespace Module\System\Controller\Ajax;


use Module\Account\Controller\Ajax;
use Module\System\Model\RoleModel;
use Module\System\Model\RolePermissionModel;
use System\Component\Validator\Validator;

/**
 * 角色ajax
 * Class Role
 * @package Module\System\Controller\Ajax
 */
class Role extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SYSTEM_ROLE_MANAGE',
        ];
    }

    /**
     * 添加角色
     */
    public function create()
    {
        $roleModel = new RoleModel();
        $data = $_POST;
        $this->preProcessData($data, RoleModel::$fields);
        $validator = new Validator();
        $rules = [
            'name' => [
                'name' => '名称',
                'value' => $data['name'],
                'rules' => [
                    'required' => []
                ]
            ],
        ];
        $validator->validate($rules);
        $error = $validator->getLastError();
        if ($error) {
            $this->message->set($error['message'], 'error');
            $this->response->refresh();
        }
        $role = $roleModel->getItem([
            'name' => $data['name']
        ]);
        if (!empty($role)) {
            $this->response->refresh();
            return $this->export([
                'code' => 'ROLE_EXISTS',
                'message' => '角色名已存在'
            ]);
        }
        $data['timeCreated'] = REQUEST_TIME;
        try {
            $id = $roleModel->add($data);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '添加角色失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'id' => $id
            ]
        ]);
    }

    /**
     * 更新
     * @return mixed
     */
    public function update()
    {
        $roleModel = new RoleModel();
        $roleId = $this->input->getInt('id');
        if (!$roleId) {
            return $this->export([
                'code' => 'ID_IS_REQUIRED',
            ]);
        }
        $data = $_POST;
        $this->preProcessData($data, RoleModel::$fields);
        try {
            $result = $roleModel->update(
                $data,
                ['id = ?', [$roleId]], [], 1
            );
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '更新角色失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }

    /**
     * 删除
     */
    public function delete()
    {
        $roleId = $this->input->getInt('id');
        if (!$roleId) {
            return $this->export([
                'code' => 'ID_IS_REQUIRED',
            ]);
        }
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();
        try {
            $result = $roleModel->delete(
                ['id = ?', [$roleId]], [], 1
            );
            $rolePermissionModel->delete(
                ['roleId=?', [$roleId]], [], 0
            );
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '删除失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }
}