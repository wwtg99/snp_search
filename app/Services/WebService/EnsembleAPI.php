<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/10/20
 * Time: 14:21
 */

namespace App\Services\WebService;


use GuzzleHttp\Client;

class EnsembleAPI
{

    /**
     * @var string
     */
    protected $host = 'http://grch37.rest.ensembl.org/variation/homo_sapiens';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $ids = [];

    /**
     * @var int
     */
    protected $timeout = 60;

    /**
     * @var array
     */
    protected $query = ['genotypes'=>0, 'phenotypes'=>0, 'pops'=>0, 'population_genotypes'=>0];

    /**
     * EnsembleAPI constructor.
     * @param array $query
     */
    public function __construct($query = null)
    {
        $this->query = $query ? array_merge($this->query, $query) : $this->query;
        $this->client = new Client(['http_errors'=>false, 'verify'=>false]);
    }

    /**
     * @param array $ids
     * @return array
     */
    public function request($ids)
    {
        if (!$ids) {
            return [];
        }
        $this->ids = $ids;
        $b = ['ids'=>$this->ids];
        $res = $this->client->post($this->host, ['json'=>$b, 'timeout'=>$this->timeout, 'query'=>$this->query]);
        if ($res && $res->getStatusCode() == 200) {
            return json_decode($res->getBody(), true);
        }
        return [];
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return EnsembleAPI
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param array $query
     * @return EnsembleAPI
     */
    public function setQuery(array $query)
    {
        $this->query = $query;
        return $this;
    }



}