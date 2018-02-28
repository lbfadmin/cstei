<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Db;

use \PDO;
use System\Bootstrap;
use System\Exception;

/**
 * PDO mysql driver extension.
 * 
 * @author xlight <i@im87.cn>
 */
class Mysql {
    
    /**
     * PDO instance.
     * @var \PDO
     */
    protected $dbh        = null;
    
    /**
     * PDO statement.
     * @var \PDOStatement
     */
    public $sth         = null;
    
    /**
     * Is connected?
     * @var bool
     */
    public $connected    = false;
    
    /**
     * Query counts.
     * @var int
     */
    public $queries      = 0;
    
    /**
     * Current SQL.
     * @var string
     */
    public $sql          = '';

    public $queryDetails = array();

    private $id          = -1;

    private $transId     = -1;

    private $timeStart = array();
    
    /**
     * Mysql parameters
     * @var array
     */
    private $params     = array(
        'port'         => 3306,
        'pconnect'     => false,
        'fetchStyle'   => \PDO::FETCH_OBJ,
        'filterFields' => true,
        'throwsInTransaction' => true,
        'throwsOnError' => true
    );
    
    /**
     * constructor init.
     * 
     * @param array $params.
     * @param array $options
     */
    function __construct($params = array(), $options = array()) {
        $this->connect($params, $options);
    }

    /**
     * connect.
     * 
     * @param array $params
     * @param array $options
     * @return object PDO object
     */
    public function connect($params = array(), $options = array()) {
        $this->params = merge_options($this->params, $params);
        $options = merge_options(array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ), $options);
        if ($this->params['pconnect']) {
            $options[PDO::ATTR_PERSISTENT] = true;
        }
        if ( !isset($this->dbh) ) {
            $this->dbh = new PDO("mysql:"
                . "host={$params['hostname']};"
                . "port={$params['hostport']};"
                . "dbname={$params['database']}",
                $params['username'], 
                $params['password'], 
                $options
            );
            $this->connected = TRUE;
        }
        return $this;
    }
    
    /**
     * prefix table.
     * 
     * @param string $table
     * @return string
     */
    public function prefix($table) {
        return $this->params['prefix'] . $table;
    }
    
    /**
     * PDO::query()
     * 
     * @param mixed ...
     * - string $sql
     * @return mixed
     */
    public function query() {
        $args = func_get_args();
        $statement = $this->preprocess($args[0]);
        $args = array($statement) + $args;

        return call_user_func_array(array($this->dbh, 'query'), $args);
    }
    
    /**
     * PDO::exec()
     */
    public function exec($statement) {
        return $this->dbh->exec($this->preprocess($statement));
    }
    
    /**
     * PDO::prepare()
     */
    public function prepare($statement, $driver_options = array()) {
        $this->sth = $this->dbh->prepare($this->preprocess($statement),
                                         $driver_options);
        if ($this->sth === false) {
            $error = $this->dbh->errorInfo();
            throw new Exception($error[2], $error[1]);
        }
        return $this->sth;
    }
    
    /**
     * Prepare a SQL to use.
     * 
     * @param string $sql
     * @return string
     */
    public function preprocess($sql) {
        $this->queries++;
        $this->id++;
        if ($this->dbh->inTransaction()) {
            $this->queryDetails[$this->transId]['queries'][$this->id] = array('SQL' => $sql);
        } else {
            $this->queryDetails[$this->id] = array('SQL' => $sql);
        }
        $this->timeStart[$this->id] = Bootstrap::timer();
        $this->sql = preg_replace('#\{([^\}]*)\}#', '`' . $this->prefix('$1') . '`', $sql);

        return $this->sql;
    }

    /**
     * 绑定参数到statement
     * @param $params
     */
    public function bindParams($params) {
        if (! empty($params)) {
            foreach ($params as $name => & $value) {
                $name = is_int($name) ? ++$name : $name;
                $type = PDO::PARAM_STR;
                $length = null;
                if (is_array($value)) {
                    $type = & $value[1];
                    $length = $value[2];
                }
                $this->sth->bindParam($name, $value, $type, $length);
            }
        }
    }

    private function stopTimer() {
        if ($this->dbh->inTransaction()) {
            $this->queryDetails[$this->transId]['queries'][$this->id]['timeTaken'] =
                Bootstrap::timer() - $this->timeStart[$this->id];
        } else {
            $this->queryDetails[$this->id]['timeTaken'] = Bootstrap::timer()
                - $this->timeStart[$this->id];
        }

    }
    
    /**
     * 获取全部结果集
     * 
     * @param mixed $sql SQL或参数数组
     * @param array $binds 绑定的数据
     * @param int $fetch_style PDO::FETCH_ASSOC|PDO::FETCH_CLASS|...
     * @param string $key 按照此键名组织结果
     * @return array|false data
     * @throws Exception
     */
    public function fetchAll($sql,
                             $binds = array(),
                             $fetch_style = null,
                             $key = '') {
        if (is_array($sql)) {
            $binds = $sql['binds'];
            $fetch_style = isset($sql['fetch_style']) ? $sql['fetch_style'] : null;
            $key = isset($sql['key']) ? $sql['key'] : '';
            $sql = $sql['sql'];
        }
        if (! $fetch_style) {
            $fetch_style = $this->params['fetchStyle'] ?: PDO::FETCH_OBJ;
        }
        $return = array();
        if ($this->sth = $this->prepare($sql)) {
            $this->bindParams($binds);
            $this->sth->execute();
            empty($binds) ?  : $this->sth->execute($binds);
            if ($this->sth->errorCode() !== '00000') {
                if ($this->params['throwsOnError']) {
                    $error = $this->sth->errorInfo();
                    throw new Exception($error[2], $error[1]);
                } else {
                    return false;
                }
            }
            $this->stopTimer();
            $result = $this->sth->fetchAll($fetch_style);
            if ($key) {
                foreach ($result as & $item) {
                    $return[$item->{$key}] = & $item;
                }
                return $return;
            } else {
                return $result;
            }
        } else {
            $error = $this->errorInfo();
            throw new Exception($error[2], $error[1]);
        }
    }
    
    /**
     * 从结果集中获取一行(不同于PDO操作)
     * 
     * @param mixed $sql
     * @param array $binds
     * @param int $fetch_style
     * @return mixed data
     * @throws Exception
     */
    public function fetch($sql,
                          $binds = array(),
                          $fetch_style = null) {
        if (is_array($sql)) {
            $binds = $sql['binds'];
            $fetch_style = $sql['fetch_style'];
            $sql = $sql['sql'];
        }
        if (! $fetch_style) {
            $fetch_style = $this->params['fetchStyle'] ?: PDO::FETCH_OBJ;
        }
        if (! preg_match('#LIMIT \d#i', $sql)) {
            $sql .= ' LIMIT 1';
        }
        if ($this->sth = $this->prepare($sql)) {
            $this->bindParams($binds);
            $this->sth->execute();
            if ($this->sth->errorCode() !== '00000') {
                if ($this->params['throwsOnError']) {
                    $error = $this->sth->errorInfo();
                    throw new Exception($error[2], $error[1]);
                } else {
                    return false;
                }
            }
            $result = $this->sth->fetch($fetch_style);
            // 有些环境无法自动释放游标
            $this->sth->closeCursor();

            $this->stopTimer();
            return $result;
        } else {
            $error = $this->errorInfo();
            throw new Exception($error[2], $error[1]);
        }
    }
    
    /**
     * 分页查询
     * 
     * @param string $sql
     * @param array $params Pager params.
     * @param array $binds
     * @param int $fetch_style
     * @return mixed data
     */
    public function pagerQuery($sql,
                               $params = array(),
                               $binds = array(),
                               $fetch_style = null) {
        if (is_array($sql)) {
            extract($sql);
        }
        $params = merge_options(array(
            'page'  => 0,
            'limit' => 10
        ), $params);
        $offset = $params['page'] * $params['limit'];
        $sql .= " LIMIT " . $offset . ",{$params['limit']}";

        return $this->fetchAll($sql, $binds, $fetch_style);
    }
    
    /**
     * Execute a SQL statement with bind values.
     * 
     * @param string $sql
     * @param array $binds
     * @return int affected rows.
     */
    public function execute($sql, $binds = array()) {
        if ($this->sth = $this->prepare($sql)) {
            $this->bindParams($binds);
            $this->sth->execute();
            if ($this->sth->errorCode() !== '00000') {
                // 事物中抛出异常
                if ($this->params['throwsOnError']
                    || ($this->params['throwsInTransaction']
                    && $this->dbh->inTransaction())) {
                    $error = $this->sth->errorInfo();
                    throw new Exception($error[2], $error[1]);
                } else {
                    return false;
                }
            }
            $this->stopTimer();
            return $this->sth->rowCount();
        }
    }
    
    public function queryErrorInfo() {
        return $this->sth->errorInfo();
    }
    
    /**
     * 单表快速插入记录
     *
     * 单条记录：
     *   $data = array('field' => 'value')
     * 多条记录：
     *   $data = array(array('field' => 'value'), array('field' => 'value'))
     *
     * @param string $table
     * @param array $data
     * @return int
     */
    public function insert($table, array $data) {
        $fields = $values = $binds = array();
        if (! is_int(key($data))) {
            $data = array($data);
        }

        $i = 0;
        foreach ($data as & $v) {
            // 过滤字段
            if ($this->params['filterFields']) {
                $v = $this->filterFields($table, $v);
            }
            $value = array();
            foreach ($v as $k1 => $v1) {
                if ($i == 0) {
                    $fields[] = "`{$k1}`";
                }
                $value[] = '?';
                $binds[] = $v1;
            }
            $values[] = '(' . implode(',', $value) . ')';
            $i++;
        }
        $values = implode(',', $values);
        $fields = implode(',', $fields);
        $sql = "INSERT "
            . " INTO {$table} ({$fields}) "
            . " VALUES {$values}";

        return $this->execute($sql, $binds) === false
            ? false
            : $this->lastInsertId();
    }
    
    /**
     * 单表便捷更新
     * 
     * @param string $table
     * @param array $data
     * @param array $conditions
     * @param array $orders
     * @param int $limit
     * @return int|bool
     * @throws Exception
     */
    public function update($table,
                           array $data,
                           array $conditions = array(),
                           array $orders = array(),
                           $limit = 0) {
        $binds = $conds = $sets = array();

        // sets
        if (empty($data)) {
            return false;
        }

        // 过滤字段
        if ($this->params['filterFields']) {
            $data = $this->filterFields($table, $data);
            if (empty($data)) {
                throw new Exception('Empty fields');
            }
        }
        foreach ($data as $field => $val) {
            if (preg_match('#^\{(.+)\}$#', $val, $m)) {
                // 测试是不是json对象
                json_decode($val);
                if (json_last_error() === JSON_ERROR_SYNTAX) {
                    $sets[] = "`{$field}` = {$m[1]}";
                    continue;
                }
            }
            $sets[] = "`{$field}` = ?";
            $binds[] = $val;
        }
        $sets = implode(',', $sets);

        // conditions
        if (! empty($conditions)) {
            $conds =  ' WHERE ' . $conditions[0];
            if (isset($conditions[1])) {
                $binds = array_merge($binds, $conditions[1]);
            }
        }

        // orders
        $orders = $orders ? ' ORDER BY ' . implode(',', $orders) : '';

        // limit
        $limit = $limit ? ' LIMIT ' . $limit : '';

        $sql = "UPDATE {$table} "
            . " SET {$sets} "
            . " {$conds} {$orders} {$limit}";

        return $this->execute($sql, $binds);
    }

    /**
     * 单表快捷删除
     * @param $table
     * @param array $conditions
     * @param array $orders
     * @param int $limit
     * @return int|bool
     */
    public function delete($table,
                           array $conditions = array(),
                           array $orders = array(),
                           $limit = 0) {
        $binds = $conds = array();
        // conditions
        if (! empty($conditions)) {
            $conds =  ' WHERE ' . $conditions[0];
            if (isset($conditions[1])) {
                $binds = array_merge($binds, $conditions[1]);
            }
        }

        // orders
        $orders = $orders ? ' ORDER BY ' . implode(',', $orders) : '';

        // limit
        $limit = $limit ? ' LIMIT ' . $limit : '';

        $sql = "DELETE "
            . " FROM {$table} "
            . " {$conds} {$orders} {$limit}";

        return $this->execute($sql, $binds);
    }

    /**
     * 过滤字段
     * @param $table
     * @param $data
     * @return array
     */
    public function filterFields($table, & $data) {
        $return = array();
        $table = preg_replace('#[`\{](.*)[`\}]#i', '$1', $table);
        // 获取字段
        $fields = array();
        $sql = "SELECT COLUMN_NAME "
            . " FROM `information_schema`.`COLUMNS`"
            . " WHERE table_name = ? "
            . " AND table_schema = ?";
        $result = $this->fetchAll(
            $sql,
            array($table, $this->params['database'])
        );
        foreach ($result as $v) {
            $fields[$v->COLUMN_NAME] = true;
        }
        foreach ($data as $field => & $value) {
            if (! isset($fields[$field])) {
                continue;
            }
            $return[$field] = $value;
        }
        return $return;
    }

    /**
     * 返回最后插入的自增ID
     * PDO::lastInsertId()
     *
     * @param mixed $name
     * @return int
     */
    public function lastInsertId($name = null) {
        return $this->dbh->lastInsertId($name);
    }
    
    /**
     * Count rows.
     * 
     * @param string $sql
     * @return int
     */
    public function rowsCount($sql) {
        $this->sth = $this->query($sql);
        return $this->sth->fetchColumn();
    }

    /**
     * 获取查询详情
     * @return array
     */
    public function getQueryDetails() {
        $time = 0;
        foreach ($this->queryDetails as $v) {
            if (isset($v['timeTaken'])) {
                $time += $v['timeTaken'];
            }
        }
        return array(
            'total'     => $this->queries,
            'detail'    => $this->queryDetails,
            'timeTaken' => $time . ' s'
        );
    }
    
    /**
     * PDO::errorInfo()
     * 
     * @return array
     */
    public function errorInfo() {
        return $this->dbh->errorInfo();
    }
    
    /**
     * PDO::beginTransaction()
     * 
     * @return bool
     */
    public function beginTransaction() {
        $this->queryDetails[++$this->transId] = array( 'Transaction' => $this->transId);
        $this->timeStart[$this->transId] = Bootstrap::timer();
        return $this->dbh->beginTransaction();
    }
    
    /**
     * PDO::commit()
     * 
     * @return bool
     * @throws Exception
     */
    public function commit() {
        $result = $this->dbh->commit();
        $this->queryDetails[$this->transId]['timeTaken'] = Bootstrap::timer()
            - $this->timeStart[$this->transId] . ' s';
        if (! $result && $this->params['throwsInTransaction']) {
            $error = $this->dbh->errorInfo();
            throw new Exception('SQL statment failed to execute', $error[1]);
        } else {
            return $result;
        }
    }
    
    /**
     * PDO::rollBack()
     * 
     * @return bool
     */
    public function rollBack() {
        return $this->dbh->rollBack();
    }
    
    /**
     * Release PDO object
     */
    public function __destruct() {
        $this->dbh = null;
    }
}