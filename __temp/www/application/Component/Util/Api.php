<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-6-23
 * Time: 下午2:20
 */
namespace Application\Component\Util;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class Api {

    private $config = [];

    private $params = [];

    public function __construct($config = []) {
        $this->config = array_merge($this->config, $config);
        $this->setParams([
            'api_key' => $this->config['apiKey'],
            'l' => ''
        ]);
    }

    public function setParams($params)
    {
        $this->params = merge_options($this->params, $params);
    }

    /**
     * 调用接口
     * @param string $api 接口名
     * @param array $params 参数
     * @return mixed
     * @throws \Exception
     */
    public function call($api, $params = []) {
        // 清理参数
        unset($params['p'], $params['authorization']);
        $params = array_merge($this->params, $params);
        $params['authorization'] = self::genAuthCode($api);
        $url = $this->config['baseUrl'] . $api;
		 // echo $url;
		 // exit;
        try {
            $response = self::post($url, $params);
        } catch (\Exception $e) {
            throw new \Exception('服务连接失败：' . $e->getMessage());
        }
        $result = $this->parseResult($response);

        return $result;
    }

    /**
     * 并发调用
     * @param ApiRequest[] $requests
     * @return array
     */
    public function callMultiple($requests) {
        $promises = $results = [];
        $client = new Client(['base_uri' => $this->config['baseUrl']]);
        foreach ($requests as $request) {
            $params = array_merge($this->params, $request->params);
            $params['authorization'] = self::genAuthCode($request->api);
            $promise = $client->postAsync($request->api, [
                'form_params' => $params
            ]);
            if ($request->callback) {
                $promise->then(function ($response) use ($request, &$results) {
                    /* @var Response $response */
                    $contents = $response->getBody()->getContents();
                    $result = $this->parseResult($contents);
                    $results[$request->api] = $result;
                    call_user_func($request->callback, $result);
                    return $response;
                });
            }
            $promises[$request->api] = $promise;
        }
        $responses = \GuzzleHttp\Promise\unwrap($promises);
        foreach ($responses as $k => $item) {
            /* @var Response $item */
            if (!isset($results[$k])) {
                $results[$k] = $this->parseResult($item->getBody()->getContents());
            }
        }
        return $results;
    }

    private function parseResult($data) {
        $result = json_decode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            if (isset($this->config['debug']) && ! $this->config['debug']) {
                throw new \Exception('服务不可用');
            } else {
                $result = $data;
            }
        }
        return $result;
    }

    private function genAuthCode($api) {
        $str = $api . ':' . $this->config['apiKey'] . ':' . $this->config['apiSecret'];
        return md5($str);
    }

    private static function post($url, $query = []) {
        foreach ($query as &$item) {
            if (is_array($item) || (is_object($item) && !($item instanceof \CURLFile))) {
                $item = json_encode($item);
            }
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		
		// print_r($url);
		//echo "<br>";
		//print_r($query);
		//exit;
		 // foreach($query as $k=>$v){
			
			 // print_r($k."=".$v."&");
		 // }
		// http://127.0.0.1:11034/content/page/get-item?api_key=www&l=&id=4&authorization=73bed1d4f3c0e5390d48ea6339273d93
		 // exit;
        $data = curl_exec($ch);
        if (curl_errno($ch) !== CURLE_OK) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);

        return $data;
    }
}