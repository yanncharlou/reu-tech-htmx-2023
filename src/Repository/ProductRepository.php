<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByTextSearch($search): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('LOWER(p.title) LIKE LOWER(:search) OR LOWER(p.shortDescription) LIKE LOWER(:search)')
            ->setParameter('search', "%$search%")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getPricesSumInCents(): int
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('SUM(p.priceInCents)')
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
