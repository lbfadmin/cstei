<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-2-14
 * Time: 下午2:00
 */

namespace Module\Common\Controller;


use Application\Controller\Front;

/**
 * 二维码
 * Class QrCode
 * @package Module\Common\Controller
 */
class QrCode extends Front
{

    /**
     * 生成二维码
     */
    public function make()
    {
        $text = $this->input->getString('text');
        $qrCode = new \Endroid\QrCode\QrCode();
        $qrCode->setText($text);
        $qrCode->setForegroundColor(['r' => 51, 'g' => 122, 'b' => 183, 'a' => 0]);
        header('Content-Type: ' . $qrCode->getContentType());
        $qrCode->render();
    }
}