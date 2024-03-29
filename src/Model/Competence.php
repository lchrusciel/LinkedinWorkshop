<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
final class Competence implements \JsonSerializable, Node
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $uuid
     * @param string $name
     */
    public function __construct($uuid, $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
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