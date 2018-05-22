<?php

namespace Offerum\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Offerum\Entity\Offer;
use Offerum\Entity\SearchCriteria;
use Offerum\Entity\User;

class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @param Offer $offer
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Offer $offer)
    {
        $this->getEntityManager()->persist($offer);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Offer $offer
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Offer $offer)
    {
        $this->getEntityManager()->remove($offer);
        $this->getEntityManager()->flush();
    }

    /**
     * @param int $offersPerPage
     * @param int $page
     *
     * @return Offer[]
     */
    public function findAllActive(int $offersPerPage = 100, int $page = 1)
    {
        return $this->createQueryBuilder('offer')
            ->select('offer')
            ->where('offer.active = true')
            ->orderBy('offer.createDate', 'DESC')
            ->setFirstResult($offersPerPage * ($page - 1))
            ->setMaxResults($offersPerPage)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param SearchCriteria $criteria
     * @param int $offersPerPage
     * @param int $page
     *
     * @return Offer[]
     *
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findByCriteria(SearchCriteria $criteria, int $offersPerPage = 100, int $page = 1)
    {
        return $this->createQueryBuilder('offer')
            ->select('offer')
            ->leftJoin('offer.category', 'category')
            ->leftJoin('offer.condition', 'condition')
            ->leftJoin('offer.deliveryType', 'delivery')
            ->orderBy('offer.createDate', 'DESC')
            ->addCriteria($criteria->getCriteria())
            ->setFirstResult($offersPerPage * ($page - 1))
            ->setMaxResults($offersPerPage)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     * @param int $offersPerPage
     * @param int $page
     *
     * @return Offer[]
     */
    public function findAllFromUser(User $user, int $offersPerPage = 100000, int $page = 1)
    {
        return $this->createQueryBuilder('offer')
            ->select('offer')
            ->where('offer.author = :author')
            ->setParameter('author', $user)
            ->orderBy('offer.createDate', 'DESC')
            ->setFirstResult($offersPerPage * ($page - 1))
            ->setMaxResults($offersPerPage)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int
     */
    public function countActive()
    {
        try {
            return $this->createQueryBuilder('offer')
                ->select('count(offer.id)')
                ->where('offer.active = true')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $exception) {
            // This should never happen
            return 0;
        }
    }

    /**
     * @param User $user
     *
     * @return int
     */
    public function countFromUser(User $user)
    {
        try {
            return $this->createQueryBuilder('offer')
                ->select('count(offer.id)')
                ->where('offer.author = :user')
                ->setParameter('user', $user)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $exception) {
            // This should never happen
            return 0;
        }
    }
}
