<?php

namespace App\Repository;

use App\Model\User;

/**
 * @author Łukasz Chruściel <lchrusciel@gmail.com>
 */
interface UserRepository
{
    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @return array|User[]
     */
    public function findAll();

    /**
     * @param User $user
     */
    public function delete(User $user);
}