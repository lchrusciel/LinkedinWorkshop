<?php

namespace App\Query;

use App\Model\Competence;
use App\Model\User;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class UserRemoveCompetenceQuery implements Query
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Competence
     */
    private $competence;

    /**
     * @param User $user
     * @param Competence $competence
     */
    public function __construct(User $user, Competence $competence)
    {
        $this->user = $user;
        $this->competence = $competence;
    }

    public function getQuery()
    {
        return 'Match (n:User {uuid: {userUuid}}) - [r] - (m:Competence {uuid: {competenceUuid}}) DELETE r';
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParameters()
    {
        return [
            'userUuid' => $this->user->getUuid(),
            'competenceUuid' => $this->competence->getUuid(),
        ];
    }
}