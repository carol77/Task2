<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @var GuardAuthenticatorHandler
     */
    private $guardAuthenticationHandler;

    /**
     * @var LoginAuthenticator
     */
    private $loginAuthenticator;

    /**
     * @param GuardAuthenticatorHandler $guardAuthenticationHandler
     * @param LoginAuthenticator $loginAuthenticator
     */
    public function __construct(GuardAuthenticatorHandler $guardAuthenticationHandler, LoginAuthenticator $loginAuthenticator)
    {
        $this->guardAuthenticationHandler = $guardAuthenticationHandler;
        $this->loginAuthenticator = $loginAuthenticator;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            $user->setRoles([User::ROLE_USER]);
            $user->setStatus(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->guardAuthenticationHandler
                ->authenticateUserAndHandleSuccess($user, $request, $this->loginAuthenticator, 'main');
            return $this->redirectToRoute('users');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
