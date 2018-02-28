<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-10-17
 * Time: 下午8:24
 */

namespace Module\Content\Model;


use Application\Component\View\AppView;
use Application\Model\BaseModel;

/**
 * 资讯
 * Class InfoModel
 * @package Module\Content\Model
 */
class InfoModel extends BaseModel
{

    public $table = '{content_info}';

    public static $fields = [
        'id',
        'category_id',
        'title',
        'source',
        'picture',
        'keywords',
        'summary',
        'body',
        'status',
        'time_published',
        'time_created',
        'time_updated',
        'hits', 
		'sort_num'
    ];

    public static $statuses = [
        'CREATED' => 4,
        'DRAFT' => 1,
        'PUBLISHED' => 2,
        'OFFLINE' => 3
    ];

    public static $statusNames = [
        'DRAFT' => '草稿',
        'PUBLISHED' => '已发布',
        'OFFLINE' => '已下线'
    ];

    /**
     * 获取一个
     * @param array $params
     * @return mixed
     */
    public function getItem($params = array())
    {
        $params = array_merge(array(
            'id' => 0,
            'fields' => '*'
        ), $params);
        $conditions = '';
        $binds = array();
        if ($params['id']) {
            $conditions .= " AND id = ?";
            $binds[] = $params['id'];
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " LIMIT 1";
        $item = $this->db->fetch($sql, $binds);
        $this->formatItems($item);
        return $item;
    }

    public function getItems($params = array())
    {
        $params = array_merge(array(
            'fields' => '*',
            'ids' => [],
            'key' => 'id',
            'order' => 'sort_num desc, id desc'
        ), $params);
        $conditions = '';
        if (!empty($params['ids'])) {
            $ids = implode(',', $params['ids']);
            $conditions .= " AND id IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $items = $this->db->fetchAll($sql, [], null, $params['key']);
        $this->formatItems($items);
        return $items;
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        $categoryIds = [];
        foreach ($list as &$item) {
            if (!empty($item->category_id)) {
                $categoryIds[$item->category_id] = $item->category_id;
            }
            if (!empty($item->picture)) {
                $item->picture = AppView::img($item->picture);
            }
            if (isset($item->status)) {
                $item->status = array_search($item->status, self::$statuses);
            }
            if (isset($item->summary) && empty($item->summary) && !empty($item->body)) {
                $item->summary = mb_substr($item->body, 0, 300);
            }
        }
        if (!empty($categoryIds)) {
            $infoCategoryModel = new InfoCategoryModel();
            $categories = $infoCategoryModel->getItems(['ids' => $categoryIds]);
            foreach ($list as &$item) {
                $item->category_name = isset($categories[$item->category_id])
                    ? $categories[$item->category_id]->name
                    : '';
            }
        }
		// print_r($item->category_name);
		// exit;
    }
	
	public function getList($params = array())
    {

        $params = array_merge(array(
            'fields' => 'id,
				uid,
				master_uid,
				category_id,
				title,
				source,
				author,
				picture,
				keywords,
				summary,
				status,
				time_published,
				time_created,
				time_updated,
				sort_num,
				hits',
				'order' => 'sort_num desc, id desc',
				'pager' => array()
        ), $params);
		// 'category_id' => 9999,

        $conditions = '';
        $binds = [];
        if ($params['keywords']) {
            $conditions .= " AND title LIKE ?";
            $binds[] = "%{$params['keywords']}%";
        }
        if ($params['category_id']) {
            $conditions .= " AND category_id = ?";
            $binds[] = "{$params['category_id']}";
        }
        if ($params['title']) {
            $conditions .= " AND title LIKE ?";
            $binds[] = "%{$params['title']}%";
        }
			if($params['parentId']){		
			$infoCategoryModel = new InfoCategoryModel();
			$categories = $infoCategoryModel->getItems(['parent_id' => $params['parentId']]);
			$cats = array();
			foreach($categories as $k=>$v){
				
				$cats[] = $k;
			}
			$conditions .= " AND category_id in (".implode($cats, ',').")";
		}

        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";

        $counter = "SELECT COUNT(id) AS count"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}";
        $result = $this->db->pagerQuery($sql, $params['pager'], $binds);
		// print_r( $params['pager']);
		// exit;
        $total = $this->db->fetch($counter, $binds)->count;

        $this->formatItems($result);

        return array(
            'list' => $result ?: array(),
            'total' => $total
        );
    }
	
	
	public function getAll($params = array())
    {

        $params = array_merge(array(
            'fields' => 'id,
				uid,
				master_uid,
				category_id,
				title,
				source,
				author,
				picture,
				keywords,
				summary,
				status,
				time_published,
				time_created,
				time_updated,
				sort_num,
				hits',
		'order' => 'sort_num desc, id desc',
            'category_id' => 9999,
            'pager' => array()
        ), $params);

        $conditions = '';
        $binds = [];
        if ($params['keywords']) {
            $conditions .= " AND title LIKE ?";
            $binds[] = "%{$params['keywords']}%";
        }
        if ($params['category_id']) {
            $conditions .= " AND category_id = ?";
            $binds[] = "{$params['category_id']}";

        }
        if ($params['title']) {
            $conditions .= " AND title LIKE ?";
            $binds[] = "%{$params['title']}%";
        }
	
		if($params['parentId']){		
			$infoCategoryModel = new InfoCategoryModel();
			$categories = $infoCategoryModel->getItems(['parent_id' => $params['parentId']]);
			$cats = array();
			foreach($categories as $k=>$v){
				
				$cats[] = $k;
			}
			$conditions .= " AND category_id in (".implode($cats, ',').")";
		}

        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table} "
            . " WHERE 1 {$conditions}"
            . " ORDER BY {$params['order']}";
        $result = $this->db->fetchAll($sql, $binds, null, $params['key']);
		// print_R($result);
		// exit;
        $this->formatItems($result);

        return array(
            'list' => $result ?: array(),
            // 'total' => $total
        );
    }

}