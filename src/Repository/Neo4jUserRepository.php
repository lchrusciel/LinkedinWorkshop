<?php

namespace App\Repository;

use App\Model\User;
use GraphAware\Bolt\Result\Result;
use GraphAware\Common\Type\Node;
use GraphAware\Neo4j\Client\Client;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
class Neo4jUserRepository implements UserRepository
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
    public function add(User $user)
    {
        $this->client->run('CREATE (n:User) SET n += {data}', ['data' => $user->convertToArray()]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function findAll()
    {
        /** @var Result $result */
        $result = $this->client->run('MATCH (n:User) RETURN n');

        $users = [];
        foreach ($result->getRecords() as $record) {
            /** @var Node $recordValue */
            $recordValue = $record->valueByIndex(0);
            $users[] = new User($recordValue->get('uuid'), $recordValue->get('firstName'), $recordValue->get('lastName'));
        }

        return $users;
    }

    /**
     * @param string $uuid
     *
     * @return User
     */
    public function find($uuid)
    {
        /** @var Result $result */
        $result = $this->client->run('MATCH (n:User {uuid: {uuid}}) RETURN n', ['uuid' => $uuid]);

        $recordValue = $result->getRecord()->valueByIndex(0);

        return new User($recordValue->get('uuid'), $recordValue->get('firstName'), $recordValue->get('lastName'));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface
     */
    public function delete($uuid)
    {
        /** @var Result $result */
        $this->client->run('MATCH (n:User {uuid: {uuid}}) DELETE n', ['uuid' => $uuid]);
    }
}