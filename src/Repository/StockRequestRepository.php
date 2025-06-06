<?php

namespace App\Repository;

use App\Entity\StockRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<StockRequest>
 */
class StockRequestRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, StockRequest::class);
        $this->security = $security;
    }

    /**
     * @return int Returns int that represent active draft or note if note than return that request id
     */
    public function getDraftStockRequestIdByUser(): int
    {
        $user = $this->security->getUser();
        $result = $this->createQueryBuilder('sr')
            ->select('sr.id')
            ->andWhere('sr.status = :status')
            ->andWhere('sr.requestedBy = :userId')
            ->setParameter('status', 'draft')
            ->setParameter('userId', $user->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $result ? $result['id'] : 0;
    }

    /**
     * @return QueryBuilder Returns an boolean that represent active draft or note
     */
    public function createActiveStockRequestsQueryBuilder(): QueryBuilder
    {
        $user = $this->security->getUser();

        if ($this->security->isGranted('ROLE_ADMIN')
            || $this->security->isGranted('ROLE_STOCK_REQUEST_REVIEWER')) {
            return $this->createQueryBuilder('sr')
                ->leftJoin('sr.fromSite', 'fs')
                ->leftJoin('sr.toSite', 'ts')
                ->addSelect('fs', 'ts') // Eager load both sites
                ->andWhere('sr.status NOT IN (:statuses)')
                ->setParameter('statuses', ['rejected', 'fulfilled'])
                ->orderBy('sr.id', 'DESC');
        }

        return $this->createQueryBuilder('sr')
            ->leftJoin('sr.fromSite', 'fs')
            ->leftJoin('sr.toSite', 'ts')
            ->addSelect('fs', 'ts') // Eager load both sites
            ->andWhere('sr.status NOT IN (:statuses)')
            ->andWhere('sr.fromSite = :site OR sr.toSite = :site OR sr.requestedBy = :user')
            ->setParameter('statuses', ['rejected', 'fulfilled'])
            ->setParameter('user', $user->getId())
            ->setParameter('site', $user->getSite())
            ->orderBy('sr.id', 'DESC');
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
