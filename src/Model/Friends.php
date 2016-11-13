<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class Friends implements \JsonSerializable, NeoArrayOfValuesProvider, Relation
{
    /**
     * @var string
     */
    const TYPE = 'FRIENDS';

    /**
     * @var User
     */
    private $n;

    /**
     * @var User
     */
    private $m;

    /**
     * @param User $firstUser
     * @param User $secondUser
     */
    public function __construct($firstUser, $secondUser)
    {
        $this->n = $firstUser;
        $this->m = $secondUser;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function getRelation()
    {
        return sprintf('CREATE (n)-[:%s]->(m)', self::TYPE);
    }

    /**
     * {@inheritdoc}
     */
    public function getNeoArrayOfValues()
    {
        return [
            'nuuid' => $this->n,
            'muuid' => $this->m,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}