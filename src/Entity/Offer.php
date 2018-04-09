<?php

namespace Offerum\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Offer
 *
 * @package Offerum\Entity
 *
 * @ORM\Entity(repositoryClass="Offerum\Repository\OfferRepository")
 */
class Offer
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Offerum\Entity\User")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var DeliveryType
     *
     * @ORM\ManyToOne(targetEntity="Offerum\Entity\DeliveryType")
     */
    private $deliveryType;

    /**
     * @var ItemCondition
     *
     * @ORM\ManyToOne(targetEntity="Offerum\Entity\ItemCondition")
     */
    private $condition;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Offerum\Entity\Category", inversedBy="offers")
     */
    private $category;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $image;

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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate(): \DateTime
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     */
    public function setCreateDate(\DateTime $createDate): void
    {
        $this->createDate = $createDate;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return DeliveryType
     */
    public function getDeliveryType(): DeliveryType
    {
        return $this->deliveryType;
    }

    /**
     * @param DeliveryType $deliveryType
     */
    public function setDeliveryType(DeliveryType $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return ItemCondition
     */
    public function getCondition(): ItemCondition
    {
        return $this->condition;
    }

    /**
     * @param ItemCondition $condition
     */
    public function setCondition(ItemCondition $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }
}
