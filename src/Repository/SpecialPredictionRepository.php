<?php

namespace App\Repository;

use App\Entity\SpecialPrediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecialPrediction|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialPrediction|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialPrediction[]    findAll()
 * @method SpecialPrediction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialPredictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialPrediction::class);
    }

     /**
      * @return SpecialPrediction[] Returns an array of SpecialPrediction objects
      */
    public function findSpecialPredictionsByAvailableRace()
    {
        return $this->createQueryBuilder('sp')
            ->select('sp', 'r')
            ->join('sp.race', 'r')
            ->where('r.isActive = :isActive')
            ->setParameter('isActive', 1)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?SpecialPrediction
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
