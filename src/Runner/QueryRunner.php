<?php

namespace App\Runner;

use App\Query\Query;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface QueryRunner
{
    /**
     * @param Query $query
     */
    public function run(Query $query);
}