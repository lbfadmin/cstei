<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Producer\Model;


use Application\Model\BaseModel;
/**
 * 生产单位
 * Class BreedingFryModel
 * @package Module\Producer\Model
 */
class BreedingPriceModel extends BaseModel
{

    protected $table = '{breeding_adultfish_price}';

    public static $fields = [
		'id',
		'quarter',
		'unit_id',
		'type',
		'大菱鲆',
		'牙鲆',
		'半滑舌鳎',
		'其他鲆鲽鱼',
		'珍珠龙胆',
		'青斑',
		'老虎斑',
		'赤点石斑鱼',
		'其他石斑鱼',
		'红鳍东方鲀',
		'暗纹东方鲀',
		'其他河鲀鱼',
		'海鲈鱼',
		'大黄鱼',
		'卵形鲳鲹',
		'军曹鱼',
		'鲷鱼',
		'美国红鱼',
		'许氏平鲉',
		'其他',
		'河鲀',
		'time_created'

    ];

   public function getSum($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'quarter DESC, type ASC',//, unit_id ASC
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        // if ($params['unit_id']) {
            // $conditions .= ' AND unit_id = ?';
            // $binds[] = $params['unit_id'];
        // }
        if ($params['unit_ids']) {
            $conditions .= ' AND unit_id in ( '.$params['unit_ids'].' )';
        }
        if ($params['quarter']) {
            $conditions .= ' AND quarter = ?';
            $binds[] = $params['quarter'];
        }
     $sql = "SELECT 
			quarter
		, type
		, SUM(大菱鲆) 大菱鲆
		, SUM(牙鲆) 牙鲆
		, SUM(半滑舌鳎) 半滑舌鳎
		, SUM(其他鲆鲽鱼) 其他鲆鲽鱼
		, SUM(珍珠龙胆) 珍珠龙胆
		, SUM(青斑) 青斑
		, SUM(老虎斑) 老虎斑
		, SUM(赤点石斑鱼) 赤点石斑鱼
		, SUM(其他石斑鱼) 其他石斑鱼
		, SUM(红鳍东方鲀) 红鳍东方鲀
		, SUM(暗纹东方鲀) 暗纹东方鲀
		, SUM(其他河鲀鱼) 其他河鲀鱼
		, SUM(海鲈鱼) 海鲈鱼
		, SUM(大黄鱼) 大黄鱼
		, SUM(卵形鲳鲹) 卵形鲳鲹
		, SUM(军曹鱼) 军曹鱼
		, SUM(鲷鱼) 鲷鱼
		, SUM(美国红鱼) 美国红鱼
		, SUM(许氏平鲉) 许氏平鲉
		, SUM(河鲀) 河鲀
		, SUM(其他) 其他"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " GROUP BY quarter, type"
            . " ORDER BY {$params['order']}";
        // $counter = "SELECT COUNT(id) AS count"
            // . " FROM {$this->table} "
            // . " WHERE 1 {$conditions}";
        $result = $this->db->fetchAll($sql, $binds);
        // $total = $this->db->fetch($counter, $binds)->count;
        // $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            // 'total' => $total
        );
    }
	

   public function _delete($params = array()) {
   
        return array(
            'list'  => array(),
            // 'total' => $total
        );
    }
	
	
    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'quarter DESC, unit_id ASC, type ASC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['id']) {
            $conditions .= ' AND id <> ?';
            $binds[] = $params['id'];
        }
        if ($params['unit_id']) {
            $conditions .= ' AND unit_id = ?';
            $binds[] = $params['unit_id'];
        }
        if ($params['unit_ids']) {
            $conditions .= ' AND unit_id in ( '.$params['unit_ids'].' )';
        }
        if ($params['quarter']) {
            $conditions .= ' AND quarter = ?';
            $binds[] = $params['quarter'];
            // $conditions .= ' AND quarter = '.$params['quarter'];
            // $binds[] = ;
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        $total = $this->db->fetch($counter, $binds)->count;
        $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            'total' => $total
        );
    }


    public function getAll($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['province_id']) {
            $conditions .= ' AND province_id = ?';
            $binds[] = $params['province_id'];
        }
        if ($params['city_id']) {
            $conditions .= ' AND city_id = ?';
            $binds[] = $params['city_id'];
        }
        if ($params['district_id']) {
            $conditions .= ' AND district_id = ?';
            $binds[] = $params['district_id'];
        }
        if ($params['block_id']) {
            $conditions .= ' AND block_id = ?';
            $binds[] = $params['block_id'];
        }
        if ($params['community_id']) {
            $conditions .= ' AND community_id = ?';
            $binds[] = $params['community_id'];
        }
        if ($params['name']) {
            $conditions .= ' AND name LIKE ?';
            $binds[] = '%' . $params['name'] . '%';
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE lng>0 {$conditions}"
            . " ORDER BY {$params['order']}";
        // $counter = "SELECT COUNT(id) AS count"
        //     . " FROM {$this->table} "
        //     . " WHERE 1 {$conditions}";
        // $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
        // $total = $this->db->fetch($counter, $binds)->count;
        $result = $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds
        ]);
        $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            // 'total' => $total
        );
    }
    public function getItems($params = [])
    {
        $params = array_merge([
            'ids' => null,
            'fields' => '*',
            'key' => 'id'
        ], $params);
        $conds = '';
        $binds = [];
        if ($params['ids']) {
            $ids = implode(',', $params['ids']);
            $conds .= " AND id IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conds}";
        $items = $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $areaIds = [];
        foreach ($list as &$item) {
            if (!empty($item->logo)) {
                $item->logo = AppView::img($item->logo);
            }
            if ($item->province_id) {
                $areaIds[$item->province_id] = $item->province_id;
            }
            if ($item->city_id) {
                $areaIds[$item->city_id] = $item->city_id;
            }
            if ($item->district_id) {
                $areaIds[$item->district_id] = $item->district_id;
            }
        }
        if (!empty($areaIds)) {
            $areaModel = new AreaModel();
            $areas = $areaModel->getItems(['ids' => $areaIds]);
            foreach ($list as &$item) {
                $item->province_name = $areas[$item->province_id]->name ?: '';
                $item->city_name = $areas[$item->city_id]->name ?: '';
                $item->district_name = $areas[$item->district_id]->name ?: '';
            }
        }
    }
}