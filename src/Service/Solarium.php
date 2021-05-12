<?php

namespace App\Service;

use Symfony\Component\EventDispatcher\EventDispatcher;

class Solarium {

    const SEARCH_CORE_PERSONS = 'personnes';
    /**
     * @var \Solarium\Core\Client\Adapter\Curl
     */
    protected $adapter;
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;
    /**
     * @var \Solarium\Client
     */
    protected $client;
    /**
     * @var $query
     */
    protected $query;

    /**
     * Solarium constructor.
     */
    public function __construct()
    {
        $this->adapter = new \Solarium\Core\Client\Adapter\Curl(); // or any other adapter implementing AdapterInterface
        $this->eventDispatcher = new EventDispatcher();
        $this->client = new \Solarium\Client($this->adapter, $this->eventDispatcher, $this->getSolrConfig());
    }

    /**
     * @return \Solarium\Core\Query\AbstractQuery|\Solarium\QueryType\Select\Query\Query
     */
    public function getQuery()
    {
        $this->query = $this->client->createSelect();

        return $this->query;
    }

    public function getFacet()
    {
        return $this->getQuery()->getFacetSet();
    }

    /**
     * @return array
     */
    protected function getSolrConfig()
    {
        return $config = [
                    'endpoint' => [
                        'localhost' => [
                            'host' => '127.0.0.1',
                            'port' => 8983,
                            'path' => '/solr/firstcol/',
                            'core' => 'personnes',
                        ]
                    ]
                ];

    }
}