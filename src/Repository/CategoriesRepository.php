<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * @extends ServiceEntityRepository<Categories>
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private CacheInterface  $cache
    )
    {
        parent::__construct($registry, Categories::class);
    }

    /**
     * @return Categories[] Returns an array of Products objects
     */
    public function findAllActive(): array
    {
        return $this->cache->get('categories', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(10);
            return $this->findAll();
        });
    }
    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categories
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
