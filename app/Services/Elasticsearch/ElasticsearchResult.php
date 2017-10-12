<?php
/**
 * Created by PhpStorm.
 * User: wuwentao
 * Date: 2017/9/29
 * Time: 16:57
 */

namespace App\Services\Elasticsearch;


class ElasticsearchResult
{

    /**
     * @var array
     */
    protected $raw = [];

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $pageSize = 10;

    /**
     * ElasticsearchResult constructor.
     * @param array $raw
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(array $raw, $page = 1, $pageSize = 10)
    {
        $this->raw = $raw;
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $meta = $this->getMeta();
        $data = [];
        if (isset($this->raw['hits']['hits'])) {
            foreach ($this->raw['hits']['hits'] as $hit) {
                $h = $this->parseHit($hit);
                if ($h) {
                    $data[] = $h;
                }
            }
        }
        return ['data'=>$data, 'meta'=>$meta];
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        $meta = [];
        if (isset($this->raw['hits'])) {
            $meta['total'] = isset($this->raw['hits']['total']) ? $this->raw['hits']['total'] : 0;
            $meta['current_page'] = $this->page;
            $meta['per_page'] = $this->pageSize;
            $meta['last_page'] = ceil(1.0 * $meta['total'] / $this->pageSize);
            $meta['from'] = ($this->page - 1) * $this->pageSize + 1;
            $meta['to'] = $meta['total'] > $this->pageSize ? $this->page * $this->pageSize : $meta['total'];
            $meta['max_score'] = isset($this->raw['hits']['max_score']) ? $this->raw['hits']['max_score'] : null;
        }
        return $meta;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * @param array $raw
     * @return ElasticsearchResult
     */
    public function setRaw(array $raw)
    {
        $this->raw = $raw;
        return $this;
    }

    /**
     * @param array $hit
     * @return array
     */
    protected function parseHit($hit)
    {
        $type = isset($hit['_type']) ? $hit['_type'] : '';
        $conf = config("search.types.$type");
        if ($conf) {
            //add label
            $label = isset($conf['label']) ? $conf['label'] : $type;
            $hit['_label'] = $label;
            $source = isset($hit['_source']) ? $hit['_source'] : [];
            if ($source) {
                //add title
                $titleHandler = isset($conf['title']) ? $conf['title'] : null;
                if ($titleHandler && is_callable($titleHandler)) {
                    $title = $titleHandler($source);
                    if ($title) {
                        $hit['_title'] = $title;
                    }
                }
                //add abstract
                $abstractHandler = isset($conf['abstract']) ? $conf['abstract'] : null;
                if ($abstractHandler && is_callable($abstractHandler)) {
                    $abstract = $abstractHandler($source);
                    if ($abstract) {
                        $hit['_abstract'] = $abstract;
                    }
                }
                //add link
                $linkHandler = isset($conf['link']) ? $conf['link'] : null;
                if ($linkHandler && is_callable($linkHandler)) {
                    $link = $linkHandler($source);
                    if ($link) {
                        $hit['_link'] = $link;
                    }
                }
                //hide fields
                $viewable = isset($conf['viewable']) ? $conf['viewable'] : null;
                if ($viewable && is_array($viewable)) {
                    foreach ($source as $k => $v) {
                        if (!in_array($k, $viewable)) {
                            unset($hit['_source'][$k]);
                        }
                    }
                }
            }
        }
        return $hit;
    }

}