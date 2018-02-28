<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-5-9
 * Time: 下午4:39
 */
namespace system\Component\Queue\Redis;

use Predis\Client;

class RedisQueueManager {

    const TASK_QUEUED = 'queued';
    const TASK_DELAYED = 'delayed';
    const TASK_RESERVED = 'reserved';

    /**
     * @var Client
     */
    private $redis = null;

    public function __construct(Client $redis) {
        $this->redis = $redis;
    }

    /**
     * 创建一个队列
     * @param $queue
     * @return int
     */
    public function create($queue) {
        $name = $this->getQueueName($queue);
        if (! $this->redis->exists($name)) {
            return $this->redis->rpush($name, '');
        }
        return 1;
    }

    /**
     * 删除一个队列
     * @param $queue
     * @return bool
     */
    public function delete($queue) {
        return (bool) $this->redis->del(array(
            $this->getQueueName($queue, self::TASK_QUEUED),
            $this->getQueueName($queue, self::TASK_RESERVED),
            $this->getQueueName($queue, self::TASK_DELAYED)
        ));
    }

    /**
     * 获取所有队列名称
     * @return array
     */
    public function getList() {
        $return = array();
        $result = $this->redis->keys('queue:*:queued');
        if (empty($result)) {
            return $return;
        }
        foreach ($result as $item) {
            preg_match('#queue:(.*):queued#i', $item, $m);
            $return[] = $m[1];
        }
        return $return;
    }

    /**
     * 获取队列全称
     * @param string $type
     * @return string
     */
    private function getQueueName($queue, $type = self::TASK_QUEUED) {
        return 'queue:' . $queue . ':' . $type;
    }

}