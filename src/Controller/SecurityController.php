<?php

namespace Offerum\Controller;

use Offerum\Command\User\SaveUserCommand;
use Offerum\Command\User\SaveUserHandler;
use Offerum\Entity\User;
use Offerum\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    public function register(Request $request, SaveUserHandler $userHandler)
    {
        $saveCommand = new SaveUserCommand();
        $form = $this->createForm(UserType::class, $saveCommand);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $saveCommand->role = User::ROLE_USER;

            $userHandler->handle($saveCommand);

            return $this->redirectToRoute('security.login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
