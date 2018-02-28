<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-4-23
 * Time: 下午4:09
 */

namespace Application\Component\Util;

class StringUtil {

    /**
     * 数据打码
     * @param  string  $string 打码的文字
     * @param  string  $type 打码数据的类型 mail 邮箱 phone 电话号码
     * @return string
     */
    static function mosaic($string,$type) {
        if($string == '')return '';
        if($type==="mail"){
            $stringArray = explode("@",$string);
            $end = strlen($stringArray[0]);
            $stringArray[0] =  substr_replace($stringArray[0],"****",1,$end-2);
            return $stringArray[0]."@".$stringArray[1];
        }
        if($type==="phone"){
            return substr_replace($string,"****",3,4);
        }
    }
}