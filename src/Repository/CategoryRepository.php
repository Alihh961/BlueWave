<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getQbAll():QueryBuilder{
        return $this->createQueryBuilder("c");
    }

    public function countCategoriesWithItemsOfType(string $typeName): int
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.items', 'i')
            ->innerJoin('i.type', 't') 
            ->where('t.name = :typeName')
            ->setParameter('typeName', $typeName)
            ->select('COUNT(DISTINCT c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getCategoriesWithItemsOfType(string $typeName , int $offset = 0 , int $maxResults){

        return $this->createQueryBuilder('c')
                ->innerJoin('c.items' , 'i')
                ->innerJoin('i.type' , 't')
                ->where('t.name = :typeName')
                ->setParameter('typeName' , $typeName)
                ->select('Distinct c.name , c.id , c.url ')
                ->setFirstResult($offset)
                ->setMaxResults($maxResults)
                ->getQuery()
                ->getResult();
    }


//    /**
//     * @return Category[] Returns an array of Category objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
