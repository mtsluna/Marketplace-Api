<?php

namespace App\Repository;

use App\Entity\StoreArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoreArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoreArea[]    findAll()
 * @method StoreArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreArea::class);
    }

    // /**
    //  * @return StoreArea[] Returns an array of StoreArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoreArea
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
