<?php

declare(strict_types=1);

namespace Product\Services;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class ProductServiceFactory
{
    public function __invoke(ContainerInterface $container) : ProductServiceInterface
    {
        $entityManager = $container->get(EntityManager::class);
        return new ProductService(
            $entityManager
        );
    }
}
