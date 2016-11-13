<?php

namespace App\Runner;

use App\Query\Query;
use GraphAware\Neo4j\Client\Client;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
class Neo4jQueryRunner implements QueryRunner
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function run(Query $query)
    {
        $this->client->run($query->getQuery(), $query->getQueryParameters());
    }
}