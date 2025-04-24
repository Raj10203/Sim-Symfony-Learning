<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
    private CacheInterface $cache,  )
    {
        parent::__construct($registry, Products::class);
    }

    public function findAllActive(): array
    {
        return $this->cache->get('products', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(600);
            return $this->createQueryBuilder('pc')
                ->select('p', 'c')
                ->from(Products::class, 'p')
                ->leftJoin('p.category', 'c')
                ->where('p.deletedAt IS NULL')
                ->orderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult();
        });
    }
    //    /**
    //     * @return Products[] Returns an array of Products objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Products
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
