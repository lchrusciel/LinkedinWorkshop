<?php

namespace App\Query;

use App\Model\User;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class UsersAddFriendshipQuery implements Query
{
    /**
     * @var User
     */
    private $user1;

    /**
     * @var User
     */
    private $user2;

    /**
     * @param User $user1
     * @param User $user2
     */
    public function __construct(User $user1, User $user2)
    {
        $this->user1 = $user1;
        $this->user2 = $user2;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return 'Match (n:User {uuid: {firstUserUuid}}) Match (m:User {uuid: {secondUserUuid}}) CREATE (n)-[r:FRIENDS]->(m)';
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParameters()
    {
        return [
            'firstUserUuid' => $this->user1->getUuid(),
            'secondUserUuid' => $this->user2->getUuid(),
        ];
    }
}