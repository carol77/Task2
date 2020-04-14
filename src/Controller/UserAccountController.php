<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Service\UserAccountManager;

/**
 * @IsGranted("ROLE_USER")
 */
class UserAccountController extends AbstractController
{
    /**
     * @var UserAccountManager
     */
    private $userAccountManager;

    /**
     * @param UserAccountManager $userAccountManager
     */
    public function __construct(UserAccountManager $userAccountManager)
    {
        $this->userAccountManager = $userAccountManager;
    }

    /**
     * @Route("/user/enableAccount/{userid}", name="enable_user_account")
     * @ParamConverter("user", options={"mapping": {"userid" : "id"}})
     * @param User $user
     * @return JsonResponse
     */
    public function enableAccount(User $user)
    {
        try {
            $this->userAccountManager->enableAccount($user);
            return new JsonResponse(['result' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['result' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * @Route("/user/disableAccount/{userid}", name="disable_user_account")
     * @ParamConverter("user", options={"mapping": {"userid" : "id"}})
     * @param User $user
     * @return JsonResponse
     */
    public function disableAccount(User $user)
    {
        try {
            $this->userAccountManager->disableAccount($user);
            return new JsonResponse(['result' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['result' => 'error', 'message' => $e->getMessage()]);
        }
    }
}