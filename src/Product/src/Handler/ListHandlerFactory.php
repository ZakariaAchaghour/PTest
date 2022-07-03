<?php

declare(strict_types=1);

namespace Product\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $responseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        return new ListHandler(
            $entityManager,
            $responseFactory,
            $resourceGenerator
        );
    }
}
