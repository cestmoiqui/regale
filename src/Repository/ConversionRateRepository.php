<?php

namespace App\Repository;

use App\Entity\ConversionRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversionRate>
 *
 * @method ConversionRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversionRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversionRate[]    findAll()
 * @method ConversionRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversionRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversionRate::class);
    }

//    /**
//     * @return ConversionRate[] Returns an array of ConversionRate objects
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

//    public function findOneBySomeField($value): ?ConversionRate
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
