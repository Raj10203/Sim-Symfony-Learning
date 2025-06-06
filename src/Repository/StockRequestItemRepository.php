<?php

namespace App\Repository;

use App\Entity\StockRequest;
use App\Entity\StockRequestItem;
use App\Enum\StockRequestItemsStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;


class StockRequestItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockRequestItem::class);
    }

    /**
     * @return QueryBuilder Returns an array of StockRequestItems objects
     */
    public function getApprovedItemsFromStockRequest(StockRequest $stockRequest): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('sri')
            ->addSelect('COALESCE(SUM(smi.quantity), 0) AS movedQuantity')
            ->addSelect('(sri.quantityApproved - COALESCE(SUM(smi.quantity), 0)) AS remainingQuantity')
            ->from(StockRequestItem::class, 'sri')
            ->join('sri.product', 'p')
            ->join('sri.stockRequest', 'sr')
            ->leftJoin('sr.stockMovements', 'sm')
            ->leftJoin('sm.stockMovementItems', 'smi', 'WITH',
                'smi.stockMovement = sm AND smi.product = p')
            ->where('sr = :stockRequest')
            ->andWhere('sri.status = :status')
            ->setParameter('stockRequest', $stockRequest)
            ->setParameter('status', StockRequestItemsStatus::Approved)
            ->groupBy('sri.id, p.name, sri.quantityApproved');
    }
}
