<?php

// src/Repository/ProductRepository.php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findFeaturedProducts(int $limit = 5): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC') // Order by creation date (newest first)
            ->setMaxResults($limit)           // Limit the number of results
            ->getQuery()
            ->getResult();
    }
}
