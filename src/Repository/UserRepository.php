<?php

namespace Offerum\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NoResultException;
use Offerum\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByUsername($username)
    {
        try
        {
            return $this->createQueryBuilder('user')
                ->select('user')
                ->where('user.username = :username')
                ->setParameter(":username", $username)
                ->getQuery()
                ->getSingleResult();
        }
        catch (NoResultException $exception) {
            return null;
        }
    }

    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function delete(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}