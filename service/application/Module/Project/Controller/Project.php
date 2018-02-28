<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 上午11:30
 */

namespace Module\Project\Controller;


use Application\Controller\Api;
use Module\Project\Model\ProjectModel;
use System\Component\Validator\Validator;

/**
 * 项目
 * Class Project
 * @package Module\Project\Controller
 */
class Project extends Api
{

    /**
     * 添加
     * @return mixed
     */
    public function create()
    {
        $data = $this->input->getArray();

        $projectModel = new ProjectModel();
        $data['time_created'] = $data['time_updated'] = date('Y-m-d H:i:s');
        try {
            $id = $projectModel->add($data);
            return $this->export([
                'data' => [
                    'id' => $id
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * 更新
     * @return mixed
     */
    public function update()
    {
        $id = $this->input->getInt('id');
        $data['desc']=$this->input->getString("desc");
        $data['time_updated'] = date('Y-m-d H:i:s');
        $projectModel = new ProjectModel();
        try {
            $result = $projectModel->update($data, ['id=?', [$id]]);
            return $this->export([
                'data' => [
                    'result' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }
    /**
     * 更新状态
     * @return mixed
     */
    public function updateStatus()
    {
        $id = $this->input->getInt('id');
        $data['status']=$this->input->getInt("status");
        $data['time_updated'] = date('Y-m-d H:i:s');
        $projectModel = new ProjectModel();
        try {
            $result = $projectModel->update($data, ['id=?', [$id]]);
            return $this->export([
                'data' => [
                    'result' => $result
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }
    }


    /**
     * 获取一条
     * @return mixed
     */
    public function getItem()
    {
        $id = $this->input->getInt('id');
        if (empty($id)) {
            return $this->export([
                'code' => $this->code('ID_IS_REQUIRED'),
                'message' => '缺少ID'
            ]);
        }
        $projectModel = new ProjectModel();
        try {
            // 基本信息
            $item = $projectModel->getItem([
                'id'  => $id,
            ]);
            if (empty($item)) {
                return $this->export([
                    'code' => $this->code('PROJECT_NOT_FOUND'),
                    'message' => '维修记录不存在'
                ]);
            }
            return $this->export([
                'data' => [
                    'project' => $item
                ]
            ]);
        } catch (\Exception $e) {
            return $this->export([
                'code' => self::STATUS_SYS_ERROR,
                'data' => $e->getTrace()
            ]);
        }
    }

    /**
     * 获取列表
     * @return mixed
     */
    public function getList()
    {
        $page = $this->input->getInt('page', 1);
        $page = $page > 0 ? $page - 1 : 0;
        $limit = $this->input->getInt('limit', 20);
        $ProjectModel = new ProjectModel();
        $params = [
            'device_name' => $this->input->getString('device_name'),
            'pager' => [
                'page' => $page,
                'limit' => $limit
            ]
        ];
        $result = $ProjectModel->getList($params);
        return $this->export([
            'data' => $result
        ]);

    }
}