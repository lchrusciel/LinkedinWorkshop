<?php

namespace App\Model;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface NeoArrayOfValuesProvider
{
    /**
     * @return array
     */
    public function getNeoArrayOfValues();
}