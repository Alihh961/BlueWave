<?php

namespace App\Repository;

use App\Entity\AccCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccCategory>
 *
 * @method AccCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccCategory[]    findAll()
 * @method AccCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccCategory::class);
    }

//    /**
//     * @return AccCategory[] Returns an array of AccCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AccCategory
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
