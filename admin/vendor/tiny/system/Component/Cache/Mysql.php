<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Cache;

use System\Bootstrap;

 /**
  * Mysql cache adapter.
  * 
  * @author xlight <i@im87.cn>
  */
class Mysql {

    /**
     * @var \System\Component\Db\Mysql
     */
    private $db = null;
    
    /**
     * Cache options
     * @var array
     */
    private static $_options = array();
    
    /**
     * Constructor
     * 
     * @param array $options
     */
    public function __construct(\System\Component\Db\Mysql $db, $table = 'cache') {
        $this->db = $db;
        $this->table = $this->db->prefix($table);
    }

    /**
     * get cache data.
     * 
     * @param string $cid cache ID.
     * @return mixed The cache or FALSE on failure.
     */
    public function get($cid) {
        $cids = array($cid);
        $cache = $this->getMultiple($cids);
        return reset($cache);
    }
    
    /**
     * get an array of cached data.
     * 
     * @param array $cids An array of cache IDs
     * @return array array cached items.
     */
    public function getMultiple($cids) {
        $placeholders = substr(str_repeat(',?', count($cids)), 1);
        $sql = "SELECT * "
            . " FROM {$this->table} "
            . " WHERE cid IN ({$placeholders})";
        $result = $this->db->fetchAll($sql, $cids, \PDO::FETCH_OBJ);
        if (! $result) return array();
        $cache = array();
        foreach ($result as $item) {
            $item = $this->prepareItem($item);
            if ($item) {
                $cache[$item->cid] = $item;
            }
        }
        
        return $cache;
    }
    
    /**
     * set cache data.
     * 
     * @param string $cid cache ID.
     * @Param mixed $data cache data.
     * @param int $expire expire time,
     */
    public function set($cid, $data, $expire = 0) {
         $_data = array(
            'serialized' => 0,
            'created' => REQUEST_TIME,
            'expire' => $expire,
        );
        if (! is_string($data)) {
            $_data['data'] = serialize($data);
            $_data['serialized'] = 1;
        } else {
          $_data['data'] = $data;
          $_data['serialized'] = 0;
        }
        $q = $this->db->update(
            $this->table,
            $_data,
            array('cid = ?', array($cid))
        );
        if ($q < 1) {
            $_data['cid'] = $cid;
            return $this->db->insert($this->table, $_data);
        }
    }
    
    /**
     * Clear all caches.
     */
    public function clear() {
        return $this->db->execute("TRUNCATE TABLE {$this->table}");
    }
    
    /**
     * Delete one cached data.
     * 
     * @param string|array $cid
     */
    public function delete($cid) {
        $placeholders = is_array($cid) 
            ? substr(str_repeat(',?', count($cid)), 1)
            : '?';
        $binds = is_array($cid) ? $cid : array($cid);
        $sql = "DELETE "
            . " FROM {$this->table}"
            . " WHERE cid IN ({$placeholders})";
        
        return $this->db->execute($sql, $binds);
    }
    
    /**
     * check if a cache is available.
     * 
     * @param mixed $cache
     * @return bool TRUE/FALSE.
     */
    public function isAvailable($cache) {
        return (bool)($cache && ($cache->expire == 0 || $cache->expire > REQUEST_TIME));
    }
    
    /**
     * Prepare a cached item.
     *
     * Checks that items are either permanent or did not expire, and unserializes
     * data as appropriate.
     *
     * @param mixed $cache cached data.
     * @return mixed prepared data.
     */
    private function prepareItem($cache) {
        if (!isset($cache->data)) {
            return FALSE;
        }
        if ($cache->serialized) {
            $cache->data = unserialize($cache->data);
        }

        return $cache;
    }
}
