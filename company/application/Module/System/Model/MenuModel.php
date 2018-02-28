<?php

namespace Module\System\Model;


use Application\Model\BaseModel;

class MenuModel extends BaseModel
{

    protected $table = '{menu}';

    public static $fields = [
        'name',
        'parent',
        'moduleId',
        'title',
        'icon',
        'url',
        'permission',
        'weight',
        'visible',
    ];

    /**
     * 获取所有菜单
     *
     * @param string $fields 获取的字段
     * @return array 结果集
     */
    public function getAll($fields = '*')
    {
        $sql = "SELECT {$fields} "
            . " FROM {$this->table} "
            . " ORDER BY weight ASC";
        return $this->db->fetchAll($sql);
    }

    /**
     * 根据id获取
     *
     * @param int $menuId
     * @return object 结果
     */
    public function getItemById($menuId)
    {
        $sql = "SELECT * FROM {menu} WHERE id = ?";
        return $this->db->fetch($sql, array($menuId));
    }

    /**
     * 更新
     *
     * @param int $menuId
     * @param array $data
     */
    public function updateItem($menuId, $data)
    {
        foreach ($data as $k => $v) {
            $sets[] = "$k = ?";
            $binds[] = $v;
        }
        $sets = implode(',', $sets);
        $binds[] = $menuId;
        $sql = "UPDATE {menu} SET {$sets}"
            . " WHERE id = ?"
            . " LIMIT 1";
        return $this->db->execute($sql, $binds);
    }

    /**
     * 删除单个菜单项
     *
     * @param int $menuId
     */
    public function deleteItem($menuId)
    {
        $sql = "DELETE FROM {menu} WHERE id = ? LIMIT 1";
        return $this->db->execute($sql, array($menuId));
    }

    /**
     * 添加模块菜单
     *
     * @param int $moduleId 模块id
     * @param array $data 数据
     * @return mixed 成功返回插入的ID，失败返回false
     */
    public function addItems($moduleId, $data)
    {
        $values = array();
        foreach ($data as $k => $v) {
            $value = array(
                "'{$v['name']}'",
                $v['title'] ? "'{$v['title']}'" : "'{$v['name']}'",
                "'{$v['icon']}'",
                "'{$v['url']}'",
                $moduleId,
                "'{$v['parent']}'",
                "'{$v['permission']}'",
                $v['weight'] ?: 0
            );
            $value = implode(',', $value);
            $values[] = "({$value})";
        }
        $values = implode(',', $values);
        $sql = "INSERT INTO {menu} "
            . " (name, title, icon, url, moduleId, parent, permission, weight)"
            . " VALUES {$values}";
        return $this->db->execute($sql);
    }

}