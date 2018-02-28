<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-5-7
 * Time: 上午11:13
 */

namespace System\Component\Queue\Redis;

use Predis\Client;
use Predis\Transaction\MultiExec;
use System\Component\Crypt\Hash;

class RedisQueue {

    /**
     * @var \Predis\Client
     */
    private $redis = null;

    private $queue = 'default';

    const TASK_QUEUED = 'queued';
    const TASK_DELAYED = 'delayed';
    const TASK_RESERVED = 'reserved';
    const TASK_CANCELED = 'canceled';

    public function __construct(Client $redis, $queue = 'default') {
        $this->redis = $redis;
        $this->queue = $queue;
    }

    /**
     * 添加一个任务到队列
     * @param string $task 任务名
     * @param array $data 附加数据
     * @param int $delay 延迟时间(s)
     */
    public function push($task, array $data, $delay = 0) {
        $payload = $this->createPayload($task, $data);
        $queue = $this->getQueueName($delay ? self::TASK_DELAYED : self::TASK_QUEUED);
        if ($delay === 0) {
            $this->redis->rpush($queue, $payload);
        } else {
            $this->redis->zadd($queue, REQUEST_TIME + $delay, $payload);
        }
        return new RedisTask($this, json_decode($payload, true));
    }

    /**
     * 从队列取出一个任务
     * @param int $wait 任务执行等待时间(s)
     * @return RedisTask|null
     */
    public function pop($wait = 0) {
        $this->migrateAllExpiredTasks();
        $task = $this->redis->lpop($this->getQueueName());
        if ($task) {
            $task = json_decode($task, true);
            // 已取消
            if ($this->redis->hexists($this->getQueueName(self::TASK_CANCELED), $task['id'])) {
                $this->redis->hdel($this->getQueueName(self::TASK_CANCELED), $task['id']);
                $this->pop();
            }
            $task['attempts']++;
            $task = $this->release($task, $wait);
            return new RedisTask($this, $task);
        }
        return null;
    }

    /**
     * 获取已队列的长度
     * @return int
     */
    public function getQueuedSize() {
        $this->migrateAllExpiredTasks();
        return $this->redis->llen($this->getQueueName(self::TASK_QUEUED));
    }

    private function migrateAllExpiredTasks() {
        $this->migrateExpiredTasks($this->getQueueName(self::TASK_DELAYED), $this->getQueueName());
        $this->migrateExpiredTasks($this->getQueueName(self::TASK_RESERVED), $this->getQueueName());
    }

    /**
     * 将一个任务放回队列
     * @param array $task
     * @param int $delay
     */
    public function release($task, $delay = 0) {
        $this->redis->zadd($this->getQueueName(self::TASK_RESERVED), REQUEST_TIME + $delay, json_encode($task));
        return $task;
    }

    /**
     * 取消一个任务
     * @param $taskId
     */
    public function cancel($taskId) {
        $this->redis->hset($this->getQueueName(self::TASK_CANCELED), $taskId, 1);
    }

    /**
     * 删除一个已回收的任务
     * @param $task
     */
    public function deleteReserved($task) {
        $this->redis->zrem($this->getQueueName(self::TASK_RESERVED), $task);
    }

    /**
     * 转移到期的任务
     */
    public function migrateExpiredTasks($from, $to) {
        $options = ['cas' => true, 'watch' => $from, 'retry' => 10];
        $this->redis->transaction($options, function(MultiExec $transaction) use ($from, $to) {
            $time = time();
            $expired = $transaction->zrangebyscore($from, '-inf', $time);
            if (! empty($expired)) {
                $transaction->zremrangebyscore($from, '-inf', $time);
                call_user_func_array([$transaction, 'rpush'], array_merge([$to], $expired));
            }
        });
    }

    /**
     * 队列长度
     * @return int
     */
    public function size() {
        $size1 = $this->redis->llen($this->getQueueName());
        $size2 = (int) $this->redis->zcount($this->getQueueName(self::TASK_DELAYED), '-inf', '+inf');
        $size3 = (int) $this->redis->zcount($this->getQueueName(self::TASK_RESERVED), '-inf', '+inf');
        $size4 = (int) $this->redis->hlen($this->getQueueName(self::TASK_CANCELED));
        return $size1 + $size2 + $size3 - $size4;
    }

    /**
     * 清空队列
     */
    public function clear() {
        $this->redis->del('queue:' . $this->queue . '*');
    }

    /**
     * 获取队列全称
     * @param string $type
     * @return string
     */
    private function getQueueName($type = self::TASK_QUEUED) {
        return 'queue:' . $this->queue . ':' . $type;
    }

    /**
     * 获取任务ID
     * @param $taskName
     * @return string
     */
    private function getTaskId($taskName) {
        return md5(sprintf(
            '%s-%s-%s-%s',
            $this->getQueueName(),
            $taskName,
            Hash::int2Alpha(time()),
            Hash::randomString(8)
        ));
    }

    /**
     * 创建任务载体
     * @param $taskName
     * @param $data
     * @param $encode
     * @return string
     */
    private function createPayload($taskName, $data, $encode = true) {
        $payload = array(
            'id'   => $this->getTaskId($taskName),
            'name' => $taskName,
            'data' => $data,
            'attempts' => 0,
        );
        return $encode ? json_encode($payload) : $payload;
    }
}