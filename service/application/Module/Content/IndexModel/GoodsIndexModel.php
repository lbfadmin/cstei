<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-6-2
 * Time: 下午2:46
 */

namespace Module\Content\IndexModel;


use Application\Model\IndexModel;

/**
 * 商品索引
 * Class GoodsIndexModel
 * @package Module\Content\IndexModel
 */
class GoodsIndexModel extends IndexModel
{

    public $index = 'content_goods';

    public $type = 'goods';

    public static $fields = [
        'id',
        'category_id',
        'name',
        'time_created',
        'time_updated',
    ];

    public static $sortTypes = [
        'score_desc' => '_score:desc',
        'created_desc' => 'time_created:desc',
        'updated_desc' => 'time_updated:desc',
    ];


    public function search($params)
    {
        $params = array_merge([
            'category_id'        => null,
            'keywords'           => '',
            'name'               => '',
            'created_start'      => '',
            'created_end'        => '',
            'uid'                => null,
            'page'               => 0,
            'limit'              => 10,
            'sort'               => 'time_published:desc'
        ], $params);
        $query = [];
        if ($params['published_only']) {
            $query['bool']['filter'][] = [
                'range' => ['time_published' => ['lt' => date('Y-m-d H:i:s')]]
            ];
        }
        if ($params['id']) {
            $query['bool']['filter'][] = [
                'term' => ['id' => $params['id']]
            ];
        }
        if ($params['category_id']) {
            $query['bool']['filter'][] = [
                'term' => ['category_id' => $params['category_id']]
            ];
        }
        if ($params['created_start']) {
            $query['bool']['filter'][] = [
                ['range' => ['time_created' => ['gte' => $params['created_start']]]]
            ];
        }
        if ($params['created_end']) {
            $query['bool']['filter'][] = [
                ['range' => ['time_created' => ['lte' => $params['created_end']]]]
            ];
        }
        if ($params['name']) {
            $query['bool']['must'] = [
                ['match' => [
                    'title' => [
                        'query' => $params['name'],
                        'minimum_should_match' => '100%',
                    ]
                ]]
            ];
        }
        if ($params['keywords']) {
            $query['bool']['should'] = [
                ['match' => [
                    'name' => [
                        'query' => $params['keywords'],
                    ],
                ]],
            ];
        }
        if (empty($query['bool'])) {
            $query = ['match_all' => (object) []];
        }
        if ($params['excludes']) {
            $query['bool']['must_not'] = [
                'ids' => ['values' => $params['excludes']]
            ];
        }

        return $this->elasticsearch->search([
            'index' => $this->index,
            'type' => $this->type,
            'from' => $params['page'] * $params['limit'],
            'size' => $params['limit'],
            'sort' => $params['sort'],
            'body' => [
                'query' => $query
            ]
        ]);
    }

}