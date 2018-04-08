<?php

namespace Offerum\Command\Offer;

use Offerum\Entity\DeliveryType;
use Offerum\Entity\ItemCondition;
use Offerum\Entity\Offer;
use Offerum\Entity\User;
use Symfony\Component\HttpFoundation\File\File;

class SaveOfferCommand
{
    /**
     * @var int|null
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var User
     */
    public $author;

    /**
     * @var \DateTime
     */
    public $createDate;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $price;

    /**
     * @var DeliveryType
     */
    public $deliveryType;

    /**
     * @var ItemCondition
     */
    public $condition;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var File
     */
    public $image;

    /**
     * @param Offer $offer
     *
     * @return SaveOfferCommand
     */
    public static function fromEntity(Offer $offer): self
    {
        $command = new self();

        $command->id = $offer->getId();
        $command->name = $offer->getName();
        $command->author = $offer->getAuthor();
        $command->createDate = $offer->getCreateDate();
        $command->description = $offer->getDescription();
        $command->price = $offer->getPrice();
        $command->deliveryType = $offer->getDeliveryType();
        $command->condition = $offer->getCondition();
        $command->active = $offer->isActive();
        $command->image = $offer->getImage();

        return $command;
    }
}
