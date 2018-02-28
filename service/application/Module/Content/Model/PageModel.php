<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-10-17
 * Time: 下午8:24
 */

namespace Module\Content\Model;


use Application\Model\BaseModel;

/**
 * 静态页
 * Class PageModel
 * @package Module\Content\Model
 */
class PageModel extends BaseModel
{

    public $table = '{content_page}';

    public static $fields = [
        'id',
        'title',
        'keywords',
        'summary',
        'body',
        'status',
        'time_published',
        'time_created',
        'time_updated'
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
            'key' => 'id'
        ), $params);
        $conditions = '';
        if (!empty($params['ids'])) {
            $ids = implode(',', $params['ids']);
            $conditions .= " AND id IN({$ids})";
        }
        $sql = "SELECT {$params['fields']}"
            . " FROM {$this->table}"
            . " WHERE 1 {$conditions}";
        $items = $this->db->fetchAll($sql, [], null, $params['key']);
        $this->formatItems($items);
        return $items;
    }

    public function getList($params = array())
    {
        $params = array_merge(array(
            'fields' => '*',
            'order' => 'id DESC',
            'pager' => array()
        ), $params);
        $conditions = '';
        $binds = [];
        if ($params['keywords']) {
            $conditions .= " AND title LIKE ?";
            $binds[] = "%{$params['keywords']}%";
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
            'list' => $result ?: array(),
            'total' => $total
        );
    }

    public function formatItems(&$items)
    {
        if (empty($items)) return;
        $list = is_array($items) ? $items : [$items];
        foreach ($list as &$item) {
            if (isset($item->status)) {
                $item->status = array_search($item->status, self::$statuses);
            }
            if (isset($item->summary) && empty($item->summary) && !empty($item->body)) {
                $item->summary = mb_substr($item->body, 0, 300);
            }
        }
    }
}