<?php

namespace App\Repository;

use App\Entity\RacePrediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RacePrediction|null find($id, $lockMode = null, $lockVersion = null)
 * @method RacePrediction|null findOneBy(array $criteria, array $orderBy = null)
 * @method RacePrediction[]    findAll()
 * @method RacePrediction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RacePredictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RacePrediction::class);
    }

    // /**
    //  * @return RacePrediction[] Returns an array of RacePrediction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RacePrediction
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
