<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-12
 * Time: 上午10:26
 */

namespace Module\Account\Controller;


use Application\Controller\Front;

/**
 * 政府端账号
 * Class Supervisor
 * @package Module\Account\Controller
 */
class Supervisor extends Front
{

    /**
     * 登录
     */
    public function login()
    {
        $this->view->render('account/supervisor/login');
    }
}