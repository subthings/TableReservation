<?php

namespace App\Repository;

use App\Entity\TableReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TableReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableReservation[]    findAll()
 * @method TableReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TableReservation::class);
    }

    // /**
    //  * @return TableReservation[] Returns an array of TableReservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TableReservation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
