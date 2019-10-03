<?php

namespace App\Repository;

use App\Entity\SpecialPredictionResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecialPredictionResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialPredictionResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialPredictionResult[]    findAll()
 * @method SpecialPredictionResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialPredictionResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialPredictionResult::class);
    }

    /**
     * @param $race
     * @return SpecialPredictionResult[] Returns an array of SpecialPredictionResult objects
     */
    public function findByAvailableRace($race)
    {
        return $this->createQueryBuilder('s')
            ->join('s.specialPrediction', 'sp')
            ->andWhere('sp.race = :race')
            ->setParameter('race', $race)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?SpecialPredictionResult
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
