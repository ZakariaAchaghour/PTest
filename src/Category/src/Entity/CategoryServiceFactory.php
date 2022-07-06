<?php

declare(strict_types=1);

namespace Category\Entity;

use Category\Entity\CategoryService;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class CategoryServiceFactory
{
    public function __invoke(ContainerInterface $container) : CategoryServiceInterface
    {
        $entityManager = $container->get(EntityManager::class);
        return new CategoryService(
            $entityManager
        );
    }
}
