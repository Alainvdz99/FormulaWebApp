<?php

namespace App\Repository;

use App\Entity\SpecialPredictionInput;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecialPredictionInput|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialPredictionInput|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialPredictionInput[]    findAll()
 * @method SpecialPredictionInput[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialPredictionInputRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialPredictionInput::class);
    }

    // /**
    //  * @return SpecialPredictionInput[] Returns an array of SpecialPredictionInput objects
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
    public function findOneBySomeField($value): ?SpecialPredictionInput
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
