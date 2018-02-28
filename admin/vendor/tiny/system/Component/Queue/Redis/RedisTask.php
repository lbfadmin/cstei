<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-5-11
 * Time: 下午1:29
 */
namespace System\Component\Queue\Redis;


class RedisTask {

    /**
     * 原始task数据
     * @var array
     */
    private $task = array();

    /**
     * @var RedisQueue
     */
    private $queue = null;

    public function __construct(RedisQueue $queue, array $task) {
        $this->queue = $queue;
        $this->task = $task;
    }

    /**
     * 删除任务
     */
    public function delete() {
        $this->queue->deleteReserved(json_encode($this->task));
    }

    /**
     * 获取队列对象
     * @return RedisQueue
     */
    public function getQueue() {
        return $this->queue;
    }

    /**
     * 将任务释放回队列
     * @param int $delay
     * @return array
     */
    public function release($delay = 0) {
        $this->delete();
        return $this->queue->release($this->task, $delay);
    }

    /**
     * 获取任务被执行次数
     * @return int
     */
    public function attempts() {
        return (int) $this->task['attempts'];
    }

    /**
     * 获取任务ID
     * @return string
     */
    public function getId() {
        return $this->task['id'];
    }

    public function getName() {
        return $this->task['name'];
    }

    /**
     * 获取原始任务数据
     * @return array
     */
    public function getRawTask() {
        return $this->task;
    }

    public function getData() {
        return $this->task['data'];
    }
}