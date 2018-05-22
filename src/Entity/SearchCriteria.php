<?php

namespace Offerum\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

class SearchCriteria
{
    /**
     * @var int[]|null
     */
    private $categoryIds;

    /**
     * @var int[]|null
     */
    private $conditionIds;

    /**
     * @var int[]|null
     */
    private $deliveryTypeIds;

    /**
     * @return int[]|null
     */
    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    /**
     * @param int[]|null $categoryIds
     */
    public function setCategoryIds($categoryIds): void
    {
        if ($categoryIds instanceof ArrayCollection) {
            $categoryIds = $categoryIds->toArray();
        }

        $this->categoryIds = $categoryIds;
    }

    /**
     * @return int[]|null
     */
    public function getConditionIds(): ?array
    {
        return $this->conditionIds;
    }

    /**
     * @param int[]|null $conditionIds
     */
    public function setConditionIds($conditionIds): void
    {
        if ($conditionIds instanceof ArrayCollection) {
            $conditionIds = $conditionIds->toArray();
        }

        $this->conditionIds = $conditionIds;
    }

    /**
     * @return int[]|null
     */
    public function getDeliveryTypeIds(): ?array
    {
        return $this->deliveryTypeIds;
    }

    /**
     * @param int[]|null $deliveryTypeIds
     */
    public function setDeliveryTypeIds($deliveryTypeIds): void
    {
        if ($deliveryTypeIds instanceof ArrayCollection) {
            $deliveryTypeIds = $deliveryTypeIds->toArray();
        }

        $this->deliveryTypeIds = $deliveryTypeIds;
    }

    /**
     * @return Criteria
     */
    public function getCriteria(): Criteria
    {
        $criteria = Criteria::create();

        // Temporary measure
        // Should be loaded from GET
        $criteria->where(Criteria::expr()->eq('active', true));

        if ($this->categoryIds) {
            $criteria->andWhere(Criteria::expr()->in('category.id', $this->categoryIds));
        }

        if ($this->conditionIds) {
            $criteria->andWhere(Criteria::expr()->in('condition.id', $this->conditionIds));
        }

        if ($this->deliveryTypeIds) {
            $criteria->andWhere(Criteria::expr()->in('delivery.id', $this->deliveryTypeIds));
        }

        return $criteria;
    }

    /**
     * Returns array with parameters used to generate URL with specified search criteria.
     *
     * @return array
     */
    public function getParams(): array
    {
        $params = [];

        if ($this->categoryIds) {
            $params["categories"] = implode(",", $this->categoryIds);
        }

        if ($this->conditionIds) {
            $params["conditions"] = implode(",", $this->conditionIds);
        }

        if ($this->deliveryTypeIds) {
            $params["deliveryTypes"] = implode(",", $this->deliveryTypeIds);
        }

        return $params;
    }

    /**
     * @param Request $request
     *
     * @return SearchCriteria
     */
    public static function fromRequest(Request $request): self
    {
        $categories = self::handleArrayInput($request->query->get('categories'));
        $conditions = self::handleArrayInput($request->query->get('conditions'));
        $deliveryTypes = self::handleArrayInput($request->query->get('deliveryTypes'));

        $criteria = new self();

        $criteria->setCategoryIds($categories);
        $criteria->setConditionIds($conditions);
        $criteria->setDeliveryTypeIds($deliveryTypes);

        return $criteria;
    }

    /**
     * @param null|string $input
     *
     * @return array|null
     */
    private static function handleArrayInput(?string $input): ?array
    {
        if (!$input) {
            return null;
        }

        $ids = explode(',', $input);
        $data = [];

        foreach ($ids as $id) {
            $data[] = (int) $id;
        }

        return count($data) > 0 ? $data : null;
    }
}
