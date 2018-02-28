<?php

namespace Module\Account\Component\Account;

use Module\Account\Model\UserModel;
use System\Bootstrap;
use System\Component\Crypt\Hash;

class Auth {

    private $model = null;
    
    /**
     * User object
     * @var object
     */
    public $user      = null;
    
    /**
     * Session timeout.
     * @var int
     */
    private $timeout   = 3600 * 4;
    
    /**
     * Cookie domain.
     * @var string
     */
    public $cookieDomain = '';
    
    /**
     * Is user logged in?
     * @var bool
     */
    private $isLogin  = false;
   
    function __construct($params = array()) {
        $config      = Bootstrap::getConfig();
        $this->model = new UserModel();
        $this->cookieDomain = $config['common']['cookieDomain'];
        if ($this->isLogin()) {
            $this->user = $this->model->getItemById($_SESSION['user']->uid);
        } else {
            $this->user = (object) array('uid' => 0);
        }
        if ($this->timeout && !headers_sent()) {
            setcookie(session_name(), session_id(), REQUEST_TIME + $this->timeout, '/', $this->cookieDomain);
        }
    }
    
    /**
     * check if a user is already login.
     * 
     * @return bool
     */
    public function isLogin() {
        return (bool) $_SESSION['user']->uid;
    } 
    
    /**
     * Set timeout.
     */
    public function setTimeout($sec) {
        $this->timeout = $sec;
    }
    
    /**
     * auth.
     */
    public function auth($name, $pass) {

        if (! $this->isLogin()) {
            // if (filter_var($name, FILTER_VALIDATE_EMAIL) === false) {
                // $user = $this->model->getItemByPhone($name);
            // } else {
                // $user = $this->model->getItemByEmail($name);
            // }
			$user = $this->model->getItemByName($name);
	
            if ($user && $user->status == UserModel::$statuses['INACTIVE']) {
                return -1;
            }
			
        // print_r(Hash::password($pass, $user->salt));
        // print_r($user->pass);
		// exit;
            if ($user && $user->pass === Hash::password($pass, $user->salt)) {
                $this->user = $user;
                $this->startSession($this->user);
            }
        }
        return $this->user;
    }
    
    /**
     * Set session
     * 
     * @param object $user
     */
    public function startSession(&$user) {
        $this->isLogin = true;
        $_SESSION['user'] = &$user;
        if ($this->timeout && !headers_sent()) {
            setcookie(session_name(), session_id(), REQUEST_TIME + $this->timeout, '/', $this->cookieDomain);
        }
    }
    
    /**
     * destroy session.
     */
    public function logout() {
        $this->isLogin = false;
        session_destroy();
        if (!headers_sent()) {
            setcookie(session_name(), '', REQUEST_TIME - 10000, '/', $this->cookieDomain);
        }
    }

}