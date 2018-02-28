<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

class PermissionModel extends BaseModel {

    protected $table = '{permission}';

    /**
     * 添加权限
     * 
     * @param int $moduleId 模块id
     * @param array $data 数据
     * @return mixed 成功返回插入的ID，失败返回false
     */
    public function addItems($moduleId, $data) {
        foreach ($data as $k => $v) {
            $values[] = "('{$k}', '{$v['title']}', '{$v['parent']}', {$moduleId})";
        }
        $values = implode(',', $values);
        $sql = "INSERT INTO {permission} "
            . " (name, title, parent, moduleId)"
            . " VALUES"
            . " {$values}";
        return $this->db->execute($sql);
    }

    public function getAll($params = []) {
        $params = array_merge([
            'fields' => '*'
        ], $params);
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

}