<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-5-4
 * Time: 下午8:24
 */

namespace Module\System\Controller\Ajax;


use Module\Account\Controller\Ajax;
use Module\System\Model\MenuModel;
use System\Component\Validator\Validator;

/**
 * 菜单ajax
 * Class Menu
 * @package Module\System\Controller\Ajax
 */
class Menu extends Ajax
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
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();
		unset($data['id']);
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        $this->preProcessData($data, MenuModel::$fields);
        $menuModel = new MenuModel();
        try {
            $id = $menuModel->add($data);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
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
        $data = $this->input->getArray();
		
	print_r($data);
		exit;
        $menuModel = new MenuModel();
        $error = $this->validate($data);
        if (!empty($error)) {
            return $this->export([
                'code' => $this->code($error['code']),
                'message' => $error['message']
            ]);
        }
        try {
            $result = $menuModel->update($data, ['name=?', [$data['name']]]);		
	
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }

    /**
     * 验证字段
     * @param array $data
     * @return array
     */
    private function validate(array &$data) {
        $this->preProcessData($data, MenuModel::$fields);
        $validator = new Validator();
        $fields[] = [
            'name' => '机器名',
            'value' => value($data, 'name'),
            'rules' => [
                'required' => ['code' => 'NAME_IS_REQUIRED'],
                'maxLength' => ['value' => 50, 'code' => 'NAME_IS_TOO_LONG'],
            ]
        ];
        $fields[] = [
            'name' => '显示名',
            'value' => value($data, 'title'),
            'rules' => [
                'required' => ['code' => 'TITLE_IS_REQUIRED'],
                'maxLength' => ['value' => 50, 'code' => 'TITLE_IS_TOO_LONG'],
            ]
        ];
        $validator->validate($fields);
        return $validator->getLastError();
    }

    /**
     * 删除
     * @return mixed
     */
    public function delete()
    {
        $name = $this->input->getString('name');
        $menuModel = new MenuModel();
        try {
            $result = $menuModel->delete(['name=?', [$name]]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage()
            ]);
        }
        return $this->export([
            'data' => [
                'result' => $result
            ]
        ]);
    }
}