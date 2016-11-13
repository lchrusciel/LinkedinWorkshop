<?php

namespace App\Repository;

use App\Model\Relation;
use GraphAware\Neo4j\Client\Client;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
class Neo4jRelationRepository implements RelationRepository
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
    public function connect(Relation $relation)
    {
        $this->client->run(
            'Match (n {uuid: {nuuid}}) Match (m {uuid: {muuid}}) ' . $relation->getRelation(), $relation->getNeoArrayOfValues()
        );
    }
}