<?php

namespace App\Query;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface Query
{
    /**
     * @return string
     */
    public function getQuery();

    /**
     * @return array
     */
    public function getQueryParameters();
}
