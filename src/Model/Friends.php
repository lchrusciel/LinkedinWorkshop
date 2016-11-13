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
     * @param User $n
     * @param User $m
     */
    public function __construct(User $n, User $m)
    {
        $this->n = $n;
        $this->m = $m;
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
            'nuuid' => $this->n->getUuid(),
            'muuid' => $this->m->getUuid(),
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