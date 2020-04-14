<?php

namespace App\Api;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserAccountInterface
{
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function enableAccount(UserInterface $user);

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function disableAccount(UserInterface $user);

}