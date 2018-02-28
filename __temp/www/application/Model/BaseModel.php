<?php


namespace Application\Model;

use System\Model;

class BaseModel extends Model {

    /**
     * mysql
     * @var \System\Component\Db\Mysql
     */
    protected $db = null;

    protected $table = '';

    public function add($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $conds = [], $orders = [], $limit = 1) {
        return $this->db->update($this->table, $data, $conds, $orders, $limit);
    }

    public function delete($conds = [], $orders = [], $limit = 1) {
        return $this->db->delete($this->table, $conds, $orders, $limit);
    }
}