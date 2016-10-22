<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface Arrayable
{
    /**
     * @return array
     */
    public function convertToArray();
}