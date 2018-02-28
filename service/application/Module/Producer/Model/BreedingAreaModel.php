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
 * Class BreedingAreaModel
 * @package Module\Producer\Model
 */
class BreedingAreaModel extends BaseModel
{

    protected $table = '{breeding_area}';

    public static $fields = [
		'id',
		'quarter',
		'unit_id',
		'type',
		'池塘养殖',
		'流水养殖',
		'循环水养殖',
		'网箱养殖',
		'time_created',
		'time_updated'
	

    ];

    public function getList($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'quarter DESC, unit_id ASC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];
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

    public function getItem($params = array()) {
        $params = array_merge(array(
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['unit_id']) {
            $conditions .= ' AND unit_id = ?';
            $binds[] = $params['unit_id'];
        }
        if ($params['quarter']) {
            $conditions .= ' AND quarter = ?';
            $binds[] = $params['quarter'];
        }
     
        if ($params['id']) {
            $conditions .= ' AND id <> ?';
            $binds[] = $params['id'];
        }
        $sql = "SELECT *"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->fetchAll([
            'sql' => $sql,
            'binds' => $binds,
            'key' => $params['key']
        ]);
        $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            'total' => $total
        );
    }
   public function getSum($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'quarter DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];

        if ($params['quarter']) {
            $conditions .= ' AND quarter = ?';
            $binds[] = $params['quarter'];
        }
     
        $sql = "SELECT quarter, sum(池塘养殖) as 池塘养殖
		, sum(流水养殖) as 流水养殖
		, sum(循环水养殖) as 循环水养殖
		, sum(网箱养殖) as 网箱养殖"
			// . ", sum('池塘养殖') as '池塘养殖'",
			// . ", sum(流水养殖) as  流水养殖",
			// . ", sum(循环水养殖) as  循环水养殖",
			// . ", sum(网箱养殖) as  网箱养殖",
		
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " GROUP BY quarter"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, array(), $binds);
        // $total = $this->db->fetch($counter, $binds)->count;
        // $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            // 'total' => $total
        );
    }

   public function getTotal($params = array()) {
        $params = array_merge(array(
            'fields' => '*',
            'order'  => 'quarter, parent_id DESC',
            'pager'   => array()
        ), $params);
        $conditions = '';
        $binds = [];

        if ($params['quarter']) {
            $conditions .= ' AND quarter = ?';
            $binds[] = $params['quarter'];
        }
     
        $sql = "SELECT quarter, parent_id, sum(池塘养殖) as 池塘养殖
			, sum(流水养殖) as 流水养殖
			, sum(循环水养殖) as 循环水养殖
			, sum(网箱养殖) as 网箱养殖"

			. " FROM {$this->table} a, company c"
			. " WHERE a.unit_id = c.id {$conditions}"
			. " GROUP BY parent_id, quarter"
			. " ORDER BY {$params['order']}";
			// . ", sum('池塘养殖') as '池塘养殖'",
			// . ", sum(流水养殖) as  流水养殖",
			// . ", sum(循环水养殖) as  循环水养殖",
			// . ", sum(网箱养殖) as  网箱养殖",
			
        // $counter = "SELECT COUNT(id) AS count"
            // . " FROM {$this->table} "
            // . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, array(), $binds);
        // $total = $this->db->fetch($counter, $binds)->count;
        // $this->formatItems($result);
        return array(
            'list'  => $result ?: array(),
            // 'total' => $total
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