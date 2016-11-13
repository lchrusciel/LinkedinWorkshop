<?php

namespace App\Repository;

use App\Model\Competence;
use GraphAware\Bolt\Result\Result;
use GraphAware\Common\Type\Node;
use GraphAware\Neo4j\Client\Client;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class Neo4jCompetenceRepository implements CompetenceRepository
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
    public function add(Competence $competence)
    {
        $this->client->run('CREATE (n:Competence) SET n += {data}', ['data' => $competence->convertToArray()]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function findAll()
    {
        /** @var Result $result */
        $result = $this->client->run('MATCH (n:Competence) RETURN n');

        $users = [];
        foreach ($result->getRecords() as $record) {
            /** @var Node $recordValue */
            $recordValue = $record->valueByIndex(0);
            $users[] = new Competence($recordValue->get('uuid'), $recordValue->get('name'));
        }

        return $users;
    }

    /**
     * {@inheritdoc}
     *
     * @return Competence
     */
    public function find($uuid)
    {
        /** @var Result $result */
        $result = $this->client->run('MATCH (n:Competence {uuid: {uuid}}) RETURN n', ['uuid' => $uuid]);

        $recordValue = $result->getRecord()->valueByIndex(0);

        return new Competence($recordValue->get('uuid'), $recordValue->get('name'));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function delete($uuid)
    {
        /** @var Result $result */
        $this->client->run('MATCH (n:Competence {uuid: {uuid}}) DELETE n', ['uuid' => $uuid]);
    }
}