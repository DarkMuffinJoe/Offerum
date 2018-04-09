<?php

namespace Offerum\Controller;

use Offerum\Repository\OfferRepository;
use Offerum\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function myOffers(OfferRepository $offerRepository, int $page)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $offerCount = $offerRepository->countFromUser($this->getUser());
        $offers = $offerRepository->findAllFromUser($this->getUser(), 8, $page);

        return $this->render('user/my_offers.html.twig', [
            'currentPage' => $page,
            'offerCount' => $offerCount,
            'offers' => $offers
        ]);
    }

    public function profile(int $id, int $page, UserRepository $userRepository, OfferRepository $offerRepository)
    {
        $user = $userRepository->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User with ID ' . $id . ' not found');
        }

        $offerCount = $offerRepository->countFromUser($user);
        $offers = $offerRepository->findAllFromUser($user, 5, $page);
        // Are there to many queries used here?

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'offers' => $offers,
            'offerCount' => $offerCount,
            'currentPage' => $page
        ]);
    }
}
