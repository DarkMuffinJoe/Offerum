<?php

namespace Offerum\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Offerum\Entity\Offer;
use Offerum\Entity\User;

class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    /**
     * @param Offer $offer
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Offer $offer)
    {
        $this->getEntityManager()->remove($offer);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array
     */
    public function findAllActive()
    {
        return $this->createQueryBuilder('offer')
            ->select('offer')
            ->where('offer.active = true')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     * @return array
     */
    public function findAllFromUser(User $user)
    {
        return $this->createQueryBuilder('offer')
            ->select('offer')
            ->where('offer.author = :author')
            ->setParameter('author', $user)
            ->getQuery()
            ->getResult();
    }
}