<?php

declare(strict_types=1);

namespace Product\Handler;

use Doctrine\ORM\EntityManager;
use Product\Services\ProductServiceInterface;
use Psr\Container\ContainerInterface;

class DeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $productService = $container->get(ProductServiceInterface::class);

        return new DeleteHandler($entityManager,$productService);
    }
}
