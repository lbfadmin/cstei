<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-12-2
 * Time: 下午2:40
 */

namespace Module\Common\Model;


use Application\Model\BaseModel;

/**
 * 临时文件
 * Class TempFileModel
 * @package Module\Common\Model
 */
class TempFileModel extends BaseModel
{

    protected $table = '{common_temp_file}';

    public static $fields = [
        'file_key',
        'time_created'
    ];

    public function add($data)
    {
        return parent::add($data);
    }
}