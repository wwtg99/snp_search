<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/9/29
 * Time: 16:17
 */

namespace App\Services\Elasticsearch;


use GuzzleHttp\Client;

class Elasticsearch
{

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $index = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Elasticsearch constructor.
     * @param string $type
     * @param string $index
     * @param array $options
     */
    public function __construct($type = '', $index = '', $options = [])
    {
        $this->host = config('services.elasticsearch.host');
        $this->index = $index ? $index : config('services.elasticsearch.index');
        $this->type = $type;
        $defOptions = ['http_errors'=>false, 'verify'=>false, 'timeout'=>10, 'base_uri'=>$this->host];
        $options = array_merge($defOptions, $options);
        $this->client = new Client($options);
    }

    /**
     * @param $query
     * @param $page
     * @param $pageSize
     * @param array $options
     * @return ElasticsearchResult
     */
    public function simpleSearch($query, $page = 1, $pageSize = 10, $options = [])
    {
        $options = array_merge($options, ['q'=>$query, 'size'=>$pageSize, 'from'=>($page - 1) * $pageSize]);
        $res = $this->client->get($this->getSearchUri(), ['query'=>$options]);
        if ($res && $res->getStatusCode() == 200) {
            $res = json_decode((string)$res->getBody(), true);
            return new ElasticsearchResult($res, $page, $pageSize);
        }
        return new ElasticsearchResult([]);
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    protected function getSearchUri()
    {
        if ($this->index) {
            return $this->type ? "/$this->index/$this->type/_search" : "/$this->index/_search";
        } else {
            return "/_search";
        }
    }

}