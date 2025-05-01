<?php

namespace App\Repository;

use App\Entity\StockRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockRequest>
 */
class StockRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockRequest::class);
    }

    /**
     * @return boolean Returns an boolean that represent active draft or note
     */
    public function getDraftStockRequestIdByUser(int $userId): int
    {
        $result = $this->createQueryBuilder('sr')
            ->select('sr.id')
            ->andWhere('sr.status = :status')
            ->andWhere('sr.requested_by = :userId')
            ->setParameter('status', 'draft')
            ->setParameter('userId', $userId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result ? $result['id'] : 0;
    }

    /**
     * @return StockRequest Returns an boolean that represent active draft or note
     */
    public function getActiveStockRequests(User $user): array
    {
        if (in_array('ROLE_ADMIN', $user->getRoles(), true) or
            in_array('ROLE_STOCK_REQUEST_REVIEWER', $user->getRoles(), true)) {
            return $this->createQueryBuilder('sr')
                ->leftJoin('sr.fromSite', 'fs')
                ->leftJoin('sr.toSite', 'ts')
                ->addSelect('fs', 'ts') // Eager load both sites
                ->andWhere('sr.status NOT IN (:statuses)')
                ->setParameter('statuses', ['rejected', 'fulfilled'])
                ->orderBy('sr.id', 'DESC')
                ->getQuery()
                ->getResult();
        }

        return $this->createQueryBuilder('sr')
            ->leftJoin('sr.fromSite', 'fs')
            ->leftJoin('sr.toSite', 'ts')
            ->addSelect('fs', 'ts') // Eager load both sites
            ->andWhere('sr.status NOT IN (:statuses)')
            ->andWhere('sr.fromSite = :site OR sr.toSite = :site')
            ->setParameter('statuses', ['rejected', 'fulfilled'])
            ->setParameter('site', $user->getSite())
            ->orderBy('sr.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?StockRequest
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
