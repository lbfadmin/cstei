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
 * 资讯索引
 * Class InfoIndexModel
 * @package Module\Content\IndexModel
 */
class InfoIndexModel extends IndexModel
{

    public $index = 'content_info';

    public $type = 'info';

    public static $fields = [
        'id',
        'category_id',
        'title',
        'source',
        'keywords',
        'summary',
        'body',
        'status',
        'time_published',
        'time_created',
        'time_updated',
    ];

    public static $sortTypes = [
        'score_desc' => '_score:desc',
        'created_desc' => 'time_created:desc',
        'updated_desc' => 'time_updated:desc',
        'published_desc' => 'time_published:desc',
    ];


    public function search($params)
    {
        $params = array_merge([
            'category_id'        => null,
            'keywords'           => '',
            'title'              => '',
            'statuses'           => null,
            'created_start'      => '',
            'created_end'        => '',
            'published_only'     => false,
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
        if ($params['category_id']) {
            $query['bool']['filter'][] = [
                'term' => ['category_id' => $params['category_id']]
            ];
        }
        if ($params['statuses']) {
            $query['bool']['filter'][] = [
                ['terms' => ['status' => $params['statuses']]]
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
        if ($params['title']) {
            $query['bool']['must'] = [
                ['match' => [
                    'title' => [
                        'query' => $params['title'],
                        'minimum_should_match' => '100%',
                    ]
                ]]
            ];
        }
        if ($params['keywords']) {
            $query['bool']['should'] = [
                ['match' => [
                    'title' => [
                        'query' => $params['keywords'],
                    ],
                ]],
                ['match' => [
                    'keywords' => [
                        'query' => $params['keywords'],
                    ]
                ]],
                ['match' => [
                    'summary' => [
                        'query' => $params['keywords'],
                    ]
                ]],
                ['match' => [
                    'body' => [
                        'query' => $params['keywords'],
                    ]
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