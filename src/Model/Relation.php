<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface Relation extends NeoArrayOfValuesProvider
{
    /**
     * @return array
     */
    public function getRelation();
}
