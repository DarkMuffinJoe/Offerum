<?php

namespace Offerum\Command\Offer;

use Offerum\Entity\Offer;
use Offerum\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveOfferHandler
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * Handles SaveOfferCommand and returns ID of the saved Offer
     *
     * @param SaveOfferCommand
     *
     * @return int
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(SaveOfferCommand $command): int
    {
        if ($command->id) {
            $offer = $this->offerRepository->find($command->id);
        } else {
            $offer = new Offer();
        }

        $offer->setName($command->name);
        $offer->setAuthor($command->author);
        $offer->setCreateDate($command->createDate);
        $offer->setDescription($command->description);
        $offer->setPrice($command->price);
        $offer->setDeliveryType($command->deliveryType);
        $offer->setCondition($command->condition);
        $offer->setCategory($command->category);
        $offer->setActive($command->active);

        if ($command->image instanceof UploadedFile) {
            $offer->setImage($command->image);
        }

        $this->offerRepository->save($offer);

        return $offer->getId();
    }
}
