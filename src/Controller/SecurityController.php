<?php

namespace Offerum\Controller;

use Offerum\Entity\User;
use Offerum\Form\UserType;
use Offerum\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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

    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $planPassword = $form->get('plainPassword')->getData();
            $password = $passwordEncoder->encodePassword($user, $planPassword);

            $user->setPassword($password);
            $user->setRole(User::ROLE_USER);

            $userRepository->save($user);

            return $this->redirectToRoute('security.login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}