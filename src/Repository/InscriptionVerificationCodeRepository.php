<?php

namespace App\Repository;

use App\Entity\InscriptionVerificationCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InscriptionVerificationCode>
 *
 * @method InscriptionVerificationCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method InscriptionVerificationCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method InscriptionVerificationCode[]    findAll()
 * @method InscriptionVerificationCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionVerificationCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InscriptionVerificationCode::class);
    }

//    /**
//     * @return InscriptionVerificationCode[] Returns an array of InscriptionVerificationCode objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InscriptionVerificationCode
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
