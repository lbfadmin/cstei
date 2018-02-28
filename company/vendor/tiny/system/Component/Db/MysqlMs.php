<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Db;

use System\Exception;

/**
 * Mysql master-slaves读写分离
 * 
 * @author xlight <i@im87.cn>
 */
class MysqlMs extends Mysql {

    private $config = [];

    private static $masterConnection = null;

    private static $slaveConnections = [];

    private $slaveIndex = null;

    private $hosts = [];
    
    public function __construct($config) {
        $this->config = $config;
        $this->hosts = $config['hosts'];
    }

    /**
     * 指定从服务器
     * @param $index
     */
    public function useSlave($index) {
        $this->slaveIndex = $index;
    }

    /**
     * 获取从服务器index
     * @return null
     */
    public function getSlaveIndex() {
        return $this->slaveIndex;
    }

    /**
     * 连接主服务器
     */
    public function connectMaster() {
        if (self::$masterConnection === null) {
            $this->dbh = null;
            $this->connect(array_merge(
                $this->config['params'],
                $this->hosts['master']
            ));
            self::$masterConnection = $this->dbh;
        } else {
            $this->dbh = self::$masterConnection;
        }
    }

    /**
     * 连接从服务器
     * @param null $index
     */
    private function connectSlave() {
        $num = count($this->hosts['slaves']);
        $index = $this->slaveIndex !== null ? $this->slaveIndex : rand(0, $num - 1);
        $this->slaveIndex = $index;
        if (self::$slaveConnections[$index] === null) {
            $this->connect(array_merge(
                $this->config['params'],
                $this->hosts['slaves'][$index]
            ));
            self::$slaveConnections[$index] = $this->dbh;
        } else {
            $this->dbh = self::$slaveConnections[$index];
        }
    }

    /**
     * 执行操作时使用主服务器
     */
    public function exec($statement) {
        $this->connectMaster();
        return parent::exec($statement);
    }

    /**
     * 执行操作时使用主服务器
     * @param string $sql
     * @param array $binds
     * @return int
     * @throws Exception
     */
    public function execute($sql, $binds = []) {
        $this->connectMaster();
        return parent::execute($sql, $binds);
    }

    /**
     * 查询时使用从服务器
     * @return mixed
     */
    public function query() {
        $this->connectSlave();
        $args = func_get_args();
        return call_user_func_array('parent::query', $args);
    }

    /**
     * 查询时使用从服务器
     * @param string $sql
     * @param array $binds
     * @param null $fetch_style
     * @return mixed
     * @throws Exception
     */
    public function fetch($sql, $binds = [], $fetch_style = null) {
        $this->connectSlave();
        return parent::fetch($sql, $binds, $fetch_style);
    }

    /**
     * 查询时使用从服务器
     * @param string $sql
     * @param array $binds
     * @param null $fetch_style
     * @return mixed
     * @throws Exception
     */
    public function fetchAll($sql, $binds = [], $fetch_style = null) {
        $this->connectSlave();
        return parent::fetchAll($sql, $binds, $fetch_style);
    }
}