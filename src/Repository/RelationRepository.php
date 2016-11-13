<?php

namespace App\Repository;

use App\Model\Relation;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface RelationRepository
{
    /**
     * @param Relation $relation
     */
    public function connect(Relation $relation);
}