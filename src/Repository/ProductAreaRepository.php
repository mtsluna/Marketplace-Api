<?php

namespace App\Repository;

use App\Entity\ProductArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductArea[]    findAll()
 * @method ProductArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductArea::class);
    }

    // /**
    //  * @return ProductArea[] Returns an array of ProductArea objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductArea
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
