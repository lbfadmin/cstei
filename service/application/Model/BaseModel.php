<?php


namespace Application\Model;

use System\Bootstrap;
use System\Model;
use System\Component\Db\Mysql;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class BaseModel
 * @package Application\Model
 * @property-read ContainerBuilder $di
 * @property-read Mysql $db
 */
class BaseModel extends Model
{

    protected $table = '';

    public function __get($name)
    {
        if ($this->di->has($name)) {
            return $this->di->get($name);
        } elseif (!empty(Bootstrap::getGlobal($name))) {
            return Bootstrap::getGlobal($name);
        } else {
            throw new \Exception('未定义的属性：' . $name);
        }
    }

    public function execute($sql, $binds = array()) {
        return $this->db->execute($sql, $binds);
	}
	
    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($data, $conditions = [], $orders = [], $limit = 1)
    {
        return $this->db->update($this->table, $data, $conditions, $orders, $limit);
    }

    public function delete($conditions = [], $orders = [], $limit = 1)
    {
		// return $limit;
        return $this->db->delete($this->table, $conditions, $orders, $limit);
    }

    public function getOne($fields = '*',
                           array $conditions = [],
                           array $orders = [])
    {
        $binds = $where = array();
        // conditions
        if (!empty($conditions)) {
            $where = ' WHERE ' . $conditions[0];
            if (isset($conditions[1])) {
                $binds = array_merge($binds, $conditions[1]);
            }
        }

        // orders
        $orders = $orders ? ' ORDER BY ' . implode(',', $orders) : '';

        $sql = "SELECT {$fields} "
            . " FROM {$this->table} "
            . " {$where} {$orders}";

        return $this->db->fetch($sql, $binds);
    }
}