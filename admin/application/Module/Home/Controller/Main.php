<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-4-14
 * Time: 上午10:51
 */

namespace Module\Home\Controller;


use Module\Account\Controller\Auth;

/**
 * Class Main
 * @package Module\Home\Controller
 */
class Main extends Auth
{

    /**
     * 控制面板
     */
    public function dashboard()
    {
        $this->view->render('home/dashboard');
    }


}