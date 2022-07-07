<?php
namespace Product\Repositories;

use Doctrine\ORM\EntityRepository;
use Product\Entity\Product;

class ProductRepository  extends EntityRepository
{
    public function findAll()
    {
            return $this->createQueryBuilder('p')
                ->andWhere('p.deletedAt IS NULL')
                ->orderBy('p.createdAt', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        
    }

    public function findById($id)
    {
            return $this->createQueryBuilder('p')
                ->where('p.deletedAt IS NULL')
                ->andWhere('p.id = :id')
                ->setParameter('id',$id)
                ->getQuery()
                ->getSingleResult()
            ;
        
    }

    public function findProductsByCategoryId($id)
    {
        return  $this->createQueryBuilder('p')
        ->innerJoin('p.categories', 'c', 'WITH', 'c.id = :id')
        ->where('p.deletedAt IS NULL')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult(); 
    }
   
}
