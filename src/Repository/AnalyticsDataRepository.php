<?php

namespace App\Repository;

use App\Entity\AnalyticsData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnalyticsData>
 *
 * @method AnalyticsData|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnalyticsData|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnalyticsData[]    findAll()
 * @method AnalyticsData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnalyticsDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnalyticsData::class);
    }

    public function save(AnalyticsData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AnalyticsData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AnalyticsData[] Returns an array of AnalyticsData objects
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

//    public function findOneBySomeField($value): ?AnalyticsData
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @return AnalyticsData[] Returns an array of AnalyticsData objects
     */
    public function findDataFromIPFromLastHour($ip): array
    {
        $lasthour = (new \DateTime())->modify('-1 hour');

        $qb = $this->createQueryBuilder('a');

        return $qb->andWhere('a.ip = :ip')
            ->andWhere($qb->expr()->gt('a.createdAt ', ':date'))
            ->setParameter('ip', $ip)
            ->setParameter('date', $lasthour)
            ->getQuery()
            ->getResult();
    }
}
