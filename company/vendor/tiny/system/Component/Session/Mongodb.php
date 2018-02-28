<?php

/**
 * xframework - 敏捷高效的php框架
 * 
 * @copyright xlight www.im87.cn
 * @license Please contact the author before using it.
 * @author xlight i@im87.cn
 */

namespace System\Component\Session;

class Mongodb {

    private $db = null;

    private $collection = null;
    
    /**
     * Session config.
     * @var array
     */
    private $config = array(
        'collection' => 'session'
    );
    
    /**
     * Constructor.
     * 
     * @param array $config
     */
    public function __construct(\MongoDB $db, array $config) {
        $this->db = $db;
        $this->config = $config;
        $this->collection = new \MongoCollection($this->db, $this->config['collection']);
        session_set_save_handler(
            array($this, 'open'), 
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
        register_shutdown_function('session_write_close');
    }
    
    /**
     * Initialize session
     */
    public function open($save_path, $sessionid) {
        return true;
    }
    
    /**
     * Read session data
     */
    public function read($sessionid) {
        $result = $this->collection->findOne(['sid' => $sessionid]);
        return ! empty($result) ? $result->data : null;
    }
    
    /**
     * Write session data
     */
    public function write($sessionid, $sessiondata) {
        $result = null;
        // Insert.
        if(is_null($this->read($sessionid))) {
            $result = $this->collection->insert([
                'sid'       => $sessionid,
                'timestamp' => REQUEST_TIME,
                'data'      => $sessiondata
            ]);
        }
        // Update.
        else{
            $result = $this->collection->update(
                ['sid' => $sessionid],
                [
                    'timestamp' => REQUEST_TIME,
                    'data' => $sessiondata
                ]
            );
        }
        if ($result === false) {
            throw new \Exception('Cannot write session');
        }
        return $result;
    }
    
    /**
     * Close the session
     */
    public function close() {
        return true;
    }
    
    /**
     * Cleanup old sessions
     */
    public function gc($maxlifetime) {
        return $this->collection->remove(
            ['timestamp' => ['$lt' => REQUEST_TIME - $maxlifetime]]
        );
    }
    
    /**
     * Destroy a session
     */
    public function destroy($sessionid) {
        return $this->collection->remove(
            ['sid' => $sessionid],
            ['justOne' => true]
        );
    }

    public function initSchema() {
        $this->db->createCollection($this->config['collection']);
    }
}
