<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-11-3
 * Time: 下午6:03
 */

namespace Application\Model;

use System\Bootstrap;
use System\Exception;
use Elasticsearch\Client;

/**
 * Elasticsearch索引
 * Class IndexModel
 * @package Application\Model
 * @property-read Client $elasticsearch
 */
abstract class IndexModel
{

    public $index = '';
    public $type = '';

    public function __construct()
    {
        foreach (Bootstrap::getGlobal() as $key => $value) {
            $this->{$key} = $value;
        }
        Bootstrap::invokeHook('onModelInit', $this);
    }

    public function __get($name)
    {
        if ($this->di->has($name)) {
            return $this->di->get($name);
        } elseif (!empty(Bootstrap::getGlobal($name))) {
            return Bootstrap::getGlobal($name);
        } else {
            throw new Exception('未定义的属性：' . $name);
        }
    }

    public function index($data, $parent = null)
    {
        return $this->elasticsearch->index([
            'index' => $this->index,
            'type' => $this->type,
            'id' => $data['id'],
            'parent' => $parent,
            'body' => $data
        ]);
    }

    public function indexAll(&$data)
    {
        $body = [];
        foreach ($data as &$item) {
            $index = [
                '_index' => $this->index,
                '_type' => $this->type,
                '_id' => $item['id'],
                '_parent' => value($item, 'parent')
            ];
            $body[] = json_encode([
                'index' => $index
            ]);
            $body[] = json_encode($item['doc']);
        }
        return $this->elasticsearch->bulk([
            'index' => $this->index,
            'type' => $this->type,
            'body' => $body
        ]);
    }

    public function update($id, $data, $parent = null)
    {
        $body = (isset($data['script']) || isset($data['doc'])) ? $data : ['doc' => $data];
        $this->elasticsearch->update([
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
            'parent' => $parent,
            'body' => $body
        ]);
    }

    public function updateAll(&$data)
    {
        $body = [];
        if (empty($data)) return false;
        foreach ($data as &$item) {
            $body[] = json_encode([
                'update' => [
                    '_index' => $this->index,
                    '_type' => $this->type,
                    '_id' => $item['id']
                ]
            ]);
            $body[] = json_encode([
                'doc' => $item['doc']
            ]);
        }
        return $this->elasticsearch->bulk([
            'index' => $this->index,
            'type' => $this->type,
            'body' => $body
        ]);
    }

    public function delete($id, $parent = null)
    {
        return $this->elasticsearch->delete([
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
            'parent' => $parent
        ]);
    }
}