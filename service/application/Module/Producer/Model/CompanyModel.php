<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-10
 * Time: 下午12:11
 */

namespace Module\Producer\Model;


use Application\Component\View\AppView;
use Application\Model\BaseModel;
use Module\Common\Model\AreaModel;

/**
 * 生产单位
 * Class CompanyModel
 * @package Module\Producer\Model
 */
class CompanyModel extends BaseModel
{

    protected $table = '{company}';

    public static $fields = [
        'id',
        'name',
        'parent_id',
        'logo',
        'province_id',
        'city_id',
        'district_id',
        'address',	//地址
        'lat',		//经度
        'lng',		//纬度
        'block_id',
        'community_id',
        'scale',
        'description',
        'products',
        'holders',
        'saltwater_fish'
    ];

	/*****************************************/
	/*取得所有的试验站/示范县*/
	/*****************************************/
    public function getList($params = array()) {
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
        if ($params['id']) {//取得试验站
            $conditions .= ' AND id = ?';
            $binds[] = $params['id'];
        }else{					
            $conditions .= ' AND parent_id = 0';
		}
		// print_r($params);
		// exit;
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
		// print_r($sql);
		// exit;
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