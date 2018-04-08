<?php

namespace Offerum\Controller;

use Offerum\Repository\OfferRepository;
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
}
