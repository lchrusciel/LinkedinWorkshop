<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface Node extends NeoArrayOfValuesProvider
{
    /**
     * @return array
     */
    public function getUuid();
}