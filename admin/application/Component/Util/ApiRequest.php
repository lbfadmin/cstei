<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-6-30
 * Time: 上午12:02
 */

namespace Application\Component\Util;


class ApiRequest {

    /**
     * @var string
     */
    public $api = '';

    /**
     * @var array
     */
    public $params = [];

    /**
     * @var callable
     */
    public $callback = null;

    public function __construct(string $api,
                                array $params = [],
                                callable $callback = null) {
        $this->api = $api;
        $this->params = $params;
        $this->callback = $callback;
    }
}