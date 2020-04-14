<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Service\AccountsManager;

/**
 * @IsGranted("ROLE_USER")
 */
class AccountsController extends AbstractController
{
    /**
     * @var AccountsManager
     */
    private $accountsManager;

    /**
     * @param AccountsManager $accountsManager
     */
    public function __construct(AccountsManager $accountsManager)
    {
        $this->accountsManager = $accountsManager;
    }

    /**
     * @Route("/users", name="users")
     * @param Request $request
     * @param DataTableFactory $dataTableFactory
     * @return JsonResponse|Response
     */
    public function getAccounts(Request $request)
    {
        $table = $this->accountsManager->getList()
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('user_account/list.html.twig', ['datatable' => $table]);
    }
}