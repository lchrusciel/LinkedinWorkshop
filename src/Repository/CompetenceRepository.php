<?php

namespace App\Repository;

use App\Model\Competence;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface CompetenceRepository
{
    /**
     * @param Competence $competence
     */
    public function add(Competence $competence);

    /**
     * @return array|Competence[]
     */
    public function findAll();

    /**
     * @param string $uuid
     */
    public function find($uuid);

    /**
     * @param string $uuid
     */
    public function delete($uuid);
}