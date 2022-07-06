<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\CategoryServiceInterface;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class DeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $categoryService = $container->get(CategoryServiceInterface::class);

        return new DeleteHandler( $entityManager,$categoryService);
    }
}
