<?php

namespace Module\Account\Model;

use Application\Model\BaseModel;

class UserModel extends BaseModel {

    protected $table = '{user}';

    public static $statuses = [
        'ACTIVE' => 1,
        'INACTIVE' => 0
    ];
    
    /**
     * 根据ID获取用户
     * 
     * @param int $uid 用户id
     * @param string $fields 查询的字段
     * @return object
     */
    public function getItemById($uid, $fields = '*') {
        $sql = "SELECT {$fields} FROM {user} WHERE uid = ? LIMIT 1";

        return $this->db->fetch($sql, array($uid));
    }
    
    /**
     * Get user by name.
     */
    public function getItemByName($name, $fields = '*') {
        $sql = "SELECT {$fields} FROM {user} WHERE name = ?";
        
        return $this->db->fetch($sql, array($name));
    }

    /**
     * Get user by email.
     */
    public function getItemByEmail($email, $fields = "*") {
        $sql = "SELECT {$fields} FROM {user} WHERE email = ?";
        
        return $this->db->fetch($sql, array($email));
    }
    
    public function getItemByPhone($phone, $fields = "*") {
        $sql = "SELECT {$fields} FROM {user} WHERE tel = ?";
        
        return $this->db->fetch($sql, array($phone));
    }

    /**
     * Transaction: 注册用户
     */
    public function add($data) {
        $this->db->beginTransaction();
        // 添加用户
        $sql = "INSERT INTO {user} (name,pass,email,tel,salt,created)"
            . " VALUES (?,?,?,?,?)";
        $binds = array(
            $data['name'], $data['hashedPass'],
            $data['email'],$data['tel'], $data['salt'],
            $data['created']
        );
        $result = $this->db->execute($sql, $binds);
        if ($result === FALSE) {
            $this->db->rollBack();
            return FALSE;
        }
        $uid = $this->db->lastInsertId();
        // 添加用户资料
        $sql = "INSERT INTO {user_profile} (uid)VALUES({$uid})";
        if ($this->db->execute($sql) === FALSE) {
            $this->db->rollBack();
            return FALSE;
        }
        if ($this->db->commit()) {
            return $uid;
        }
    }

    /**
     * 获取角色
     */
    public function getRoleNames($uids, $fields = '*') {
        $uids = implode(',', $uids);
        $sql = "SELECT {$fields} FROM {user_role} ur"
            . " LEFT JOIN {role} r USING(rid)"
            . " WHERE uid IN ({$uids})";
        return $this->db->fetchAll($sql);
    }
    
}