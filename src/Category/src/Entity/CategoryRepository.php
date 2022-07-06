<?php
namespace Category\Entity;
use Doctrine\ORM\EntityRepository;

class CategoryRepository  extends EntityRepository
{
    

    public function findAll()
    {
            return $this->createQueryBuilder('c')
                ->andWhere('c.deletedAt IS NULL')
                ->orderBy('c.createdAt', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        
    }

    public function findById($id)
    {
            return $this->createQueryBuilder('c')
                ->where('c.deletedAt IS NULL')
                ->andWhere('c.id = :id')
                ->setParameter('id',$id)
                ->getQuery()
                ->getSingleResult()
            ;
        
    }
}