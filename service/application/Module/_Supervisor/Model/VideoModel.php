<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2017/1/7
 * Time: 下午6:14
 */

namespace Module\Supervisor\Model;


use Application\Model\BaseModel;
use Module\Project\Model\ProductionUnitModel;

/**
 * 视频
 * Class VideoModel
 * @package Module\Supervisor\Model
 */
class VideoModel extends BaseModel
{

    protected $table = '{supervision_video}';

    public static $fields = [
        'id', 'title', 'production_unit_id', 'device_sn', 'description', 'src',
        'pool_id', 'time_created', 'time_updated'
    ];

    public function getItem($params = [])
    {
        $params = array_merge([
            'id' => null,
            'fields' => '*'
        ], $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $item = $this->db->fetch($sql, $binds);
        $this->formatItems($item);
        return $item;
    }

    public function getAll($params = [])
    {
        $params = array_merge([
            'fields' => '*',
            'name' => '',
            'key' => 'id'
        ], $params);
        $conditions = '';
        $binds = [];
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        return $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
    }

    public function getList($params = [])
    {
        $params = array_merge(array(
            'fields' => 'A.*',
            'order' => 'A.id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        $joins = ' LEFT JOIN {production_unit} B ON A.production_unit_id = B.id';
        if ($params['production_unit_id']) {
            $conditions .= ' AND A.production_unit_id = ?';
            $binds[] = $params['production_unit_id'];
        }
        if ($params['production_unit_name']) {
            $conditions .= ' AND B.name LIKE ?';
            $binds[]= "%{$params['production_unit_name']}%";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} A"
            . $joins
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(1) AS count"
            . " FROM {$this->table} A"
            . $joins
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        $this->formatItems($result);
        return array(
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    private function formatItems(&$items)
    {
        $list = is_array($items) ? $items : [$items];
        $productionUnitIds = [];
        foreach ($list as &$item) {
            if ($item->production_unit_id) {
                $productionUnitIds[$item->production_unit_id] = $item->production_unit_id;
            }
        }
        if (!empty($productionUnitIds)) {
            $model = new ProductionUnitModel();
            $productionUnits = $model->getItems(['ids' => $productionUnitIds]);
            foreach ($list as &$item) {
                if (isset($productionUnits[$item->production_unit_id])) {
                    $item->production_unit_name = $productionUnits[$item->production_unit_id]->name;
                }
            }
        }
    }
}