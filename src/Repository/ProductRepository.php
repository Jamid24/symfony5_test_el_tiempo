<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function findAllProducts(): array
    {
        return $this->findAll();
    }
    
    public function findById(int $productId): ?Product
    {
        return $this->find($productId);
    }
    
    public function findProductsByPagination(int $limit = 5, int $offset = 0): ?Array
    {
        $query = $this->createQueryBuilder("p")
            //->orderBy('p.product_name', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();
           
        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($limit * $offset) // Offset
            ->setMaxResults($limit);
        return ['paginator' => $paginator, 'products' => $paginator->getQuery()->getResult()]; 
    }

}
