<?php

namespace App\Repository;

use App\Entity\StockRequest;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return StockRequest Returns an boolean that represent active draft or note
     */
    public function getActiveStockRequests(): array
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
