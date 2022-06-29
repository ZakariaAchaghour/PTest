<?php

declare(strict_types=1);

namespace Category\Handler;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $entityManager = $container->get(EntityManager::class);
        return new ListHandler($entityManager);
    }
}
