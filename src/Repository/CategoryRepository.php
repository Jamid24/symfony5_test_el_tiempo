<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    
    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }
    
    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
    
    public function getCategoriesByProductId(int $product_id): array
    {
        $params = [
            ':id' => $this->getEntityManager()->getConnection()->quote($product_id),
        ];
        $query = 'SELECT category_id FROM category_by_product WHERE product_id = :id';
        $categoriesId =  $this->getEntityManager()->getConnection()->executeQuery(\strtr($query, $params))->fetchAllAssociative();
        $categories = [];
        foreach ($categoriesId as $categoryId){
            $categories [] = $this->find($categoryId);
        }
        return $categories;
    }
    
    
}