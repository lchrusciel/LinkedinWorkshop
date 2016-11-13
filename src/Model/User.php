<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class User implements \JsonSerializable, Node
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param string $uuid
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($uuid, $firstName, $lastName)
    {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    public function getNeoArrayOfValues()
    {
        return get_object_vars($this);
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}