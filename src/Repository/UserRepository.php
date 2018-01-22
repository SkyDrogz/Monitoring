<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;


class UserRepository extends  EntityRepository implements UserLoaderInterface
{


    public function loadUserByUsername($identifiant)
    {
        return $this->createQueryBuilder('u')
            ->where('u.identifiant = :identifiant OR u.email = :email')
            ->setParameter('identifiant', $identifiant)
            ->setParameter('email', $identifiant)
            ->getQuery()
            ->getOneOrNullResult();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
