<?php

namespace Offerum\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @package Offerum\Entity
 *
 * @ORM\Entity()
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Offer[]
     *
     * @ORM\OneToMany(targetEntity="Offerum\Entity\Offer", mappedBy="category")
     */
    private $offers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Offer[]
     */
    public function getOffers(): array
    {
        return $this->offers;
    }

    /**
     * @param Offer[] $offers
     */
    public function setOffers(array $offers): void
    {
        $this->offers = $offers;
    }
}
