<?php

namespace Module\System\Model;

use Application\Model\BaseModel;

class ModuleModel extends BaseModel {

    protected $table = '{module}';

    /**
     * 卸载模块
     * 
     * @param int $id 模块id
     * @return bool
     */
    public function _delete($moduleId) {
        $this->db->beginTransaction();
        $result = $this->deleteInfo($moduleId);
        if ($result === false) {
            $this->db->rollBack();
            return false;
        }
        
        $result = $this->deletePermissions($moduleId);
        if ($result === false) {
            $this->db->rollBack();
            return false;
        }

        $result = $this->deleteMenus($moduleId);
        if ($result === false) {
            $this->db->rollBack();
            return false;
        }
        
        $result = $this->deleteBlocks($moduleId);
        if ($result === false) {
            $this->db->rollBack();
            return false;
        }
        
        return $this->db->commit();
    }

    /**
     * 更新
     * 
     * @param int $moduleId
     * @param array $data
     */
    public function updateItem($moduleId, $data) {
        foreach ($data as $k => $v) {
            $sets[] = "{$k} = ?";
            $binds[] = $v;
        }
        $sets = implode(',', $sets);
        $binds[] = $moduleId;
        $sql = "UPDATE {module} SET {$sets} WHERE id = ?";
        return $this->db->execute($sql, $binds);
    }
    
    /**
     * 获取模块
     * 
     * @param array $params 参数
     * @return object 查询结果
     */
    public function getItem($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'name'   => '',
            'id'     => 0
        ), $params);
        $conds = '';
        $binds = array();
        if ($params['name']) {
            $conds .= " AND name = :name";
            $binds[':name'] = strtolower($params['name']);
        }
        if ($params['id']) {
            $conds .= " AND id = :id";
            $binds[':id'] = $params['id'];
        }
        $sql = "SELECT {$params['fields']} "
            . " FROM {module} "
            . " WHERE 1 {$conds}"
            . " LIMIT 1";

        return $this->db->fetch($sql, $binds);
    }

    /**
     * 获取模块列表
     * 
     * @param string $params 查询参数
     * @return object 查询结果
     */
    public function getItemList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'limit'  => 0,
            'pager' => []
        ), $params);
        $list = array();
        $limit = $params['limit']
            ? " LIMIT {$params['limit']}"
            : '';
        $sql = "SELECT {$params['fields']} "
            . " FROM {module}"
            . " ORDER BY id DESC "
            . $limit;

        $result = $params['pager'] 
            ? $this->db->pagerQuery($sql, $params['pager'])
            : $this->db->fetchAll($sql);
        if ($result) {
            foreach ($result as $k => $v) {
                $v->author = unserialize($v->author);
                $list[$v->id] = $v;
            }
        }
            
        return $list;
    }

    public function getItems($params) {
        $params = array_merge(array(
            'ids' => array(),
            'fields' => '*'
        ), $params);
        $items = array();
        $ids = implode(',', $params['ids']);
        $sql = "SELECT {$params['fields']}"
            . " FROM {module}"
            . " WHERE id IN({$ids})";
        $result = $this->db->fetchAll($sql);
        if ($result) {
            foreach ($result as & $v) {
                $items[$v->id] = $v;
            }
        }
        return $items;
    }
    
    /**
     * 获取菜单
     * 
     * @param string $parent 父菜单
     * @return array 结果集
     */
    public function getMenus($parent = '') {
        $sql = "SELECT * "
            . " FROM {menu} "
            . " WHERE parent = :parent"
            . " ORDER BY weight ASC";
            
        return $this->db->fetchAll($sql, array(':parent' => $parent));
    }
    
    /**
     * 根据名称查询菜单
     * 
     * @param string $name 菜单名
     * @return object 结果
     */
    public function getMenuByName($name) {
        $sql = "SELECT * FROM {menu} WHERE name = :name LIMIT 1";
        return $this->db->fetch($sql, array(':name' => $name));
    }

    /**
     * 获取所有菜单
     * 
     * @param string $fields 获取的字段
     * @return array 结果集
     */
    public function getAllMenus($fields = '*') {
        $sql = "SELECT {$fields} "
            . " FROM {menu} "
            . " ORDER BY weight ASC";
        $result = $this->db->fetchAll($sql);
        return $result;
    }

    /**
     * 记录数统计
     * 
     * @return int 统计结果
     */
    public function count() {
        $sql = "SELECT COUNT(1) AS count"
            . " FROM {module}"
            . " WHERE 1";
            
        return $this->db->fetch($sql)->count;
    }
}