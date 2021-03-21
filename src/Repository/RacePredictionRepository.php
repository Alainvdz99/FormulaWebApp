<?php

namespace App\Repository;

use App\Entity\RacePrediction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

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

    /**
     * @param $race
     * @return RacePrediction[] Returns an array of RacePrediction objects
     */
    public function findAllByRace($race)
    {
        return $this->createQueryBuilder('r')
            ->where('r.race = :race')
            ->setParameter('race', $race)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $raceId
     * @param int $userId
     * @return RacePrediction|null
     * @throws NonUniqueResultException
     */
    public function checkIfRacePredictionExist(int $raceId, int $userId): ?RacePrediction
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :userId')
            ->andWhere('r.race = :raceId')
            ->setParameters([
                'raceId' => $raceId,
                'userId' => $userId
            ])
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
