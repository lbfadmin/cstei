<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 17-3-6
 * Time: 上午11:02
 */

namespace Module\Project\Model;


use Application\Model\BaseModel;

/**
 * 批次-养殖池
 * Class BatchPoolModel
 * @package Module\Project\Model
 */
class BatchPoolModel extends BaseModel
{

    protected $table = '{production_batch_pool}';

    public static $fields = [
        'id',
        'batch_sn',
        'pool_id'
    ];

    public function getItemsBySns($sns)
    {
        $result = [];
        $sns = "'" . implode("','", $sns) . "'";
        $sql = "SELECT * "
            . " FROM {$this->table}"
            . " WHERE batch_sn IN({$sns})";
        $items = $this->db->fetchAll($sql);
        foreach ($items as $item) {
            $result[$item->batch_sn][] = $item->pool_id;
        }
        return $result;
    }

    public function getBatchesByPool($poolId)
    {
        $result = [];
        $sql = "SELECT * "
            . " FROM {$this->table}"
            . " WHERE pool_id = ?";
        $items = $this->db->fetchAll($sql, [$poolId]);
        foreach ($items as $item) {
            $result[] = $item->batch_sn;
        }
        return $result;
    }
}