<?php

declare(strict_types=1);

namespace Product\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Product\Services\ProductServiceInterface;
use Psr\Container\ContainerInterface;

class EditHandlerFactory
{
   
    public function __invoke(ContainerInterface $container) : EditHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $responseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $productService = $container->get(ProductServiceInterface::class);
        
        return new EditHandler(
            $entityManager,
            $responseFactory,
            $resourceGenerator,
            $productService
        );
    }
}
