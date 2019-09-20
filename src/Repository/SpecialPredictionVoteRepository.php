<?php

namespace App\Repository;

use App\Entity\SpecialPredictionVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecialPredictionVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialPredictionVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialPredictionVote[]    findAll()
 * @method SpecialPredictionVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialPredictionVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialPredictionVote::class);
    }

    // /**
    //  * @return SpecialPredictionVote[] Returns an array of SpecialPredictionVote objects
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
    public function findOneBySomeField($value): ?SpecialPredictionVote
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
