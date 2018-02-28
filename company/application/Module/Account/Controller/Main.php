<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-4
 * Time: 下午1:54
 */

namespace Module\Account\Controller;


use Application\Controller\Front;
use System\Component\Util\StringUtil;

/**
 * 账号操作
 * Class Main
 * @package Module\Account\Controller
 */
class Main extends Front
{

    /**
     * 登录
     */
    public function login()
    {
        if (empty($_POST)) {
            $this->view->render('account/login');
        } else {
            $filter = new StringUtil();
            $email = $filter->getPlainText($this->input->getString('username'));
            $pass = $filter->getPlainText($this->input->getString('password'));
            $result = $this->auth->auth($email, $pass);
// print_r($pass);
// exit;
            if ($result->uid) {
                $this->response->redirect(url('dashboard'));
            } elseif ($result === -1) {
                $this->message->set('账号已被禁用，如有疑问请联系管理员。', 'error');
                $this->response->redirect(url('account/login'));
            } else {
                $this->message->set('账号不存在或邮箱密码输入有误。', 'error');
                $this->response->redirect(url('account/login'));
            }
        }
    }

    /**
     * 注销
     */
    public function logout()
    {
        $this->auth->logout();
        $this->response->redirect(url('account/login'));
    }
}