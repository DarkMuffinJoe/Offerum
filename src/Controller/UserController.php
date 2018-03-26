<?php

namespace Offerum\Controller;

use Offerum\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function myOffers(OfferRepository $offerRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $offers = $offerRepository->findAllFromUser($this->getUser());

        return $this->render('user/my_offers.html.twig', [
            'offers' => $offers
        ]);
    }
}