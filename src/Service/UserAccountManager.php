<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\UserAccountInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserAccountManager implements UserAccountInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function enableAccount(UserInterface $user)
    {
        if(!$user) {
            throw $this->createNotFoundException('User Not Found');
        }
        $user->setStatus(true);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function disableAccount(UserInterface $user)
    {
        if(!$user) {
            throw $this->createNotFoundException('User Not Found');
        }
        $user->setStatus(false);
        $this->entityManager->flush();
    }
}