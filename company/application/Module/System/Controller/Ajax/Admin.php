<?php

namespace Module\System\Controller\Ajax;


use Module\Account\Controller\Ajax;
use Module\System\Model\RoleModel;
use Module\System\Model\UserModel;
use Module\System\Model\UserRoleModel;
use System\Component\Crypt\Hash;
use System\Component\Validator\Validator;

/**
 * 管理员ajax
 * Class Admin
 * @package Module\System\Controller\Ajax
 */
class Admin extends Ajax
{

    /**
     * 权限定义
     * @return array
     */
    public function permission()
    {
        return [
            '__ALL__' => 'SYSTEM_ADMIN_MANAGE'
        ];
    }

    /**
     * 添加管理员
     */
    public function create()
    {
        $modelAdminUser = new UserModel();
        $modelUserRole = new UserRoleModel();
        $data = $_POST;
        $this->preProcessData($data, ['name', 'email', 'roleId', 'pass']);
        $validator = new Validator();
        $fields = [
            'name' => [
                'name' => '昵称',
                'value' => $data['name'],
                'rules' => [
                    'required' => []
                ]
            ],
            'email' => [
                'name' => '邮箱',
                'value' => $data['email'],
                'rules' => [
                    'required' => [],
                    'email' => []
                ]
            ],
            'pass' => [
                'name' => '密码',
                'value' => $data['pass'],
                'rules' => [
                    'required' => [],
                    'minLength' => ['value' => 6],
                    'maxLength' => ['value' => 20]
                ]
            ],
        ];
        $validator->validate($fields);
        $error = $validator->getLastError();
        if ($error) {
            return $this->export([
                'code' => $error['code'],
                'message' => $error['message']
            ]);
        }
        $user = $modelAdminUser->getItem([
            'email' => $data['email']
        ]);
        if ($user) {
            return $this->export([
                'code' => 'EMAIL_EXISTS',
                'message' => '邮箱已存在'
            ]);
        }
        $data['salt'] = Hash::randomString();
        $data['pass'] = Hash::password($data['pass'], $data['salt']);
        $data['status'] = 1;
        $data['timeCreated'] = REQUEST_TIME;
        $roleId = value($data, 'roleId');
        unset($data['roleId']);
        try {
            $this->db->beginTransaction();
            $userId = $modelAdminUser->add($data);
            $modelUserRole->add([
                'userId' => $userId,
                'roleId' => $roleId
            ]);
            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
        return $this->export([
            'data' => [
                'id' => $userId
            ]
        ]);
    }

    /**
     * 更新
     * @return mixed
     */
    public function update()
    {
        $userId = $this->input->getInt('uid');
        if (!$userId) {
            return $this->export([
                'code' => 'UID_IS_REQUIRED',
            ]);
        }
        $modelAdminUser = new UserModel();
        $modelUserRole = new UserRoleModel();
        $userRole = $modelUserRole->getAll([
            'userId' => $userId
        ])[0];
        $data = $_POST;
        $roleId = $data['roleId'];
        $this->preProcessData($data, ['uid', 'name', 'roleId', 'email', 'pass']);
        if ($data['pass']) {
            $data['salt'] = Hash::randomString();
            $data['pass'] = Hash::password($data['pass'], $data['salt']);
        } else {
            unset($data['pass']);
        }
        unset($data['roleId']);
        try {
            if ($userId != 1) {
                if (!$userRole) {
                    $modelUserRole->add([
                        'userId' => $userId,
                        'roleId' => $roleId
                    ]);
                } else {
                    $modelUserRole->update(
                        ['roleId' => $roleId],
                        ['userId = ?', [$userId]]
                    );
                }
            }
            $modelAdminUser->update(
                $data,
                ['uid = ?', [$userId]], [], 1
            );
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '保存失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => 1
            ]
        ]);
    }

    /**
     * 禁用账号
     */
    public function block()
    {
        $userId = $_REQUEST['uid'];
        if (!$userId) {
            $this->error('缺少ID');
        }
        $modelAdminUser = new UserModel();

        try {
            $data['status'] = 0;
            $modelAdminUser->update(
                $data,
                ['uid = ?', [$userId]], [], 1
            );
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '更新失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => 1
            ]
        ]);
    }

    /**
     * 启用账号
     */
    public function unblock()
    {
        $userId = $_REQUEST['uid'];
        if (!$userId) {
            return $this->export([
                'code' => 'UID_IS_REQUIRED',
            ]);
        }
        $modelAdminUser = new UserModel();

        try {
            $data['status'] = 1;
            $modelAdminUser->update(
                $data,
                ['uid = ?', [$userId]], [], 1
            );
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => '更新失败:' . $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => 1
            ]
        ]);
    }
}