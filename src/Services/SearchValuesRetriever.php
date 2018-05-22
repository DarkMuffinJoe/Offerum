<?php

namespace Offerum\Services;

use Doctrine\ORM\EntityManagerInterface;
use Offerum\Entity\Category;
use Offerum\Entity\DeliveryType;
use Offerum\Entity\ItemCondition;

class SearchValuesRetriever
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Returns array with all possible search options.
     *
     * @return array
     */
    public function getAllValues()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $conditions = $this->entityManager->getRepository(ItemCondition::class)->findAll();
        $deliveryTypes = $this->entityManager->getRepository(DeliveryType::class)->findAll();

        return [
            "categories" => $categories,
            "conditions" => $conditions,
            "deliveryTypes" => $deliveryTypes
        ];
    }
}
