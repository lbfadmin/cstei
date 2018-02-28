<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-24
 * Time: 下午8:34
 */

namespace Module\Common\Component;


use GuzzleHttp\Client;
use Module\Common\Model\AreaModel;
use Symfony\Component\DomCrawler\Crawler;

/**
 * 抓取地区数据
 * Class AreaCrawler
 * @package Module\Common\Component
 */
class AreaCrawler
{

    private $baseUrl = 'http://www.stats.gov.cn/';

    /**
     * @var Client
     */
    private $http = null;

    private $model = null;

    public function __construct(AreaModel $model)
    {
        $this->http = new Client();
        $this->model = $model;
    }

    public function crawl()
    {
        $this->getProvinces();
    }

    /**
     * 获取省级
     */
    private function getProvinces()
    {
        $areas = [];
        $url = $this->baseUrl . 'tjsj/tjbz/tjyqhdmhcxhfdm/2015/index.html';
        $response = $this->http->get($url);
        $data = $response->getBody()->getContents();
        $crawler = new Crawler($data);
        $crawler
            ->filter('.provincetr td')
            ->reduce(function (Crawler $node, $i) use ($url) {
                $linkNode = $node->filter('a');
                $name = $linkNode->text();
                echo "{$name} >\n";
                $id = $this->model->add(['name' => $name]);
                $this->getCities($linkNode, $url, $id);
            });
        return $areas;
    }

    /**
     * 获取城市
     */
    private function getCities(Crawler $parentNode, $parentUrl, $parentId)
    {
        $url = preg_replace('#([^/]+)$#', $parentNode->attr('href'), $parentUrl);
        $response = $this->http->get($url);
        $data = $response->getBody()->getContents();
        $crawler = new Crawler($data);
        $crawler
            ->filter('.citytr td')
            ->reduce(function (Crawler $node, $i) use ($url, $parentId) {
                $linkNode = $node->filter('a');
                if ($linkNode->count() > 0) {
                    $name = $linkNode->text();
                    if (is_numeric($name)) return;
                    echo " -- {$name} >\n";
                    $id = $this->model->add([
                        'name' => $name,
                        'parent_id' => $parentId
                    ]);
                    $this->getDistricts($linkNode, $url, $id);
                }
            });
    }

    /**
     * 获取市区
     */
    private function getDistricts(Crawler $parentNode, $parentUrl, $parentId)
    {
        $url = preg_replace('#([^/]+)$#', $parentNode->attr('href'), $parentUrl);
        $response = $this->http->get($url);
        $data = $response->getBody()->getContents();
        $crawler = new Crawler($data);
        $crawler
            ->filter('.countytr td')
            ->reduce(function (Crawler $node, $i) use ($url, $parentId) {
                $linkNode = $node->filter('a');
                if ($linkNode->count() > 0) {
                    $name = $linkNode->text();
                    if (is_numeric($name)) return;
                    echo " ---- {$name} >\n";
                    $id = $this->model->add([
                        'name' => $name,
                        'parent_id' => $parentId
                    ]);
                    $this->getBlocks($linkNode, $url, $id);
                }
            });
    }

    /**
     * 获取街道
     */
    private function getBlocks(Crawler $parentNode, $parentUrl, $parentId)
    {
        $url = preg_replace('#([^/]+)$#', $parentNode->attr('href'), $parentUrl);
        $response = $this->http->get($url);
        $data = $response->getBody()->getContents();
        $crawler = new Crawler($data);
        $crawler
            ->filter('.towntr td')
            ->reduce(function (Crawler $node, $i) use ($url, $parentId) {
                $linkNode = $node->filter('a');
                if ($linkNode->count() > 0) {
                    $name = $linkNode->text();
                    if (is_numeric($name)) return;
                    echo " ------ {$name} >\n";
                    $id = $this->model->add([
                        'name' => $name,
                        'parent_id' => $parentId
                    ]);
                    $this->getCommunities($linkNode, $url, $id);
                }
            });
    }

    /**
     * 获取社区/居委会
     */
    private function getCommunities(Crawler $parentNode, $parentUrl, $parentId)
    {
        $url = preg_replace('#([^/]+)$#', $parentNode->attr('href'), $parentUrl);
        $response = $this->http->get($url);
        $data = $response->getBody()->getContents();
        $crawler = new Crawler($data);
        $communities = [];
        $crawler
            ->filter('.villagetr td')
            ->reduce(function (Crawler $node, $i) use (&$communities, $parentId) {
                $name = $node->text();
                if (is_numeric($name)) return;
                $communities[] = [
                    'name' => $name,
                    'parent_id' => $parentId
                ];
            });
        if (!empty($communities)) {
            $this->model->add($communities);
        }
    }
}