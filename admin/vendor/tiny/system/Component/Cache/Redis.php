<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-7-2
 * Time: 下午11:13
 */

namespace System\Component\Cache;

class Redis {

    /**
     * @var \Predis\Client
     */
    private $redis = null;

    private $options = array(
        'prefix' => 'cache:'
    );

    public function __construct(\Predis\Client $client, array $options = array()) {
        $this->redis = $client;
    }

    /**
     * 设置缓存
     * @param $cid
     * @param null $data
     * @param int $expire
     */
    public function set($cid, $data = null, $expire = 0) {
        $data = json_encode($data);
        $this->redis->set($this->options['prefix'] . $cid, $data);
        if ($expire) {
            $this->redis->expireat($this->options['prefix'] . $cid, $expire);
        }
    }

    /**
     * 获取一条缓存
     * @param $cid
     * @return mixed|null
     */
    public function get($cid) {
        $result = $this->redis->get($this->options['prefix'] . $cid);
        return $result ? json_decode($result) : null;
    }

    /**
     * 获取多条缓存
     * @param array $cids
     * @return array
     */
    public function getMultiple(array $cids) {
        foreach ($cids as & $cid) {
            $cid = $this->options['prefix'] . $cid;
        }
        $results = $this->redis->mget($cids);
        if ($results) {
            foreach ($results as & $data) {
                $data = $data ? json_decode($data) : null;
            }
        }
        return $results;
    }

    /**
     * 删除一条缓存
     * @param $cid
     * @return int
     */
    public function delete($cid) {
        $cids = is_array($cid) ? $cid : array($cid);
        foreach ($cids as & $cid) {
            $cid = $this->options['prefix'] . $cid;
        }
        return $this->redis->del($cid);
    }

    /**
     * 清空缓存
     * @return bool
     */
    public function clear() {
        $cursor = 0;
        while (true) {
            $result = $this->redis->scan($cursor);
            if ($result[1]) {
                $this->redis->del($result[1]);
            }
            if ($result[0] == 0) {
                break;
            }
        };
        return true;
    }

}