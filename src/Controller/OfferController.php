<?php

namespace Offerum\Controller;

use Offerum\Command\Offer\SaveOfferCommand;
use Offerum\Command\Offer\SaveOfferHandler;
use Offerum\Entity\SearchCriteria;
use Offerum\Form\OfferType;
use Offerum\Repository\OfferRepository;
use Offerum\Services\SearchValuesRetriever;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends AbstractController
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function index(Request $request, int $page, SearchValuesRetriever $searchValuesRetriever)
    {
        $criteria = SearchCriteria::fromRequest($request);

        $offerCount = count($this->offerRepository->findByCriteria($criteria));
        $offers = $this->offerRepository->findByCriteria($criteria, 8, $page);

        return $this->render('offer/index.html.twig', [
            "currentPage"=> $page,
            "offerCount" => $offerCount,
            "offers" => $offers,
            "searchValues" => $searchValuesRetriever->getAllValues(),
            "params" => $criteria->getParams()
        ]);
    }

    public function create(Request $request, SaveOfferHandler $offerHandler)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $saveCommand = new SaveOfferCommand();
        $form = $this->createForm(OfferType::class, $saveCommand, [
            'validation_groups' => ['Default', 'Create']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $saveCommand->author = $this->getUser();
            $saveCommand->active = true;
            $saveCommand->createDate = new \DateTime();

            $offerId = $offerHandler->handle($saveCommand);

            return $this->redirectToRoute('offer.show', [
                'id' => $offerId
            ]);
        }

        return $this->render('offer/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function edit(Request $request, int $id, SaveOfferHandler $offerHandler)
    {
        $offer = $this->offerRepository->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('Offer with ID ' . $id . ' not found');
        }

        if ($offer->getAuthor() != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $saveCommand = SaveOfferCommand::fromEntity($offer);
        $form = $this->createForm(OfferType::class, $saveCommand, [
            'validation_groups' => ['Default']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offerHandler->handle($saveCommand);

            return $this->redirectToRoute('user.my_offers');
        }

        return $this->render('offer/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function delete(int $id)
    {
        $offer = $this->offerRepository->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('Offer with ID ' . $id . ' not found');
        }

        if ($offer->getAuthor() != $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $this->offerRepository->delete($offer);

        return $this->redirectToRoute('user.my_offers');
    }

    public function show(int $id)
    {
        $offer = $this->offerRepository->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('Offer with ID ' . $id . ' not found');
        }

        return $this->render('offer/show.html.twig', [
            'offer' => $offer
        ]);
    }
}
