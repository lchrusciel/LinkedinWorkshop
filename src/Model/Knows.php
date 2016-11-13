<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class Knows implements \JsonSerializable, NeoArrayOfValuesProvider, Relation
{
    /**
     * @var string
     */
    const TYPE = 'KNOWS';

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
     * @param Competence $secondUser
     */
    public function __construct($firstUser, $secondUser)
    {
        $this->n = $firstUser;
        $this->m = $secondUser;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE;
    }

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
        return $this->getNeoArrayOfValues();
    }
}