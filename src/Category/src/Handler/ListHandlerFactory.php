<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\CategoryService;
use Category\Entity\CategoryServiceInteface;
use Category\Entity\CategoryServiceInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $responseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $categoryService = $container->get(CategoryServiceInterface::class);
        
        return new ListHandler(
            $entityManager,
            $responseFactory,
            $resourceGenerator,
            $categoryService
            
        );
    }
}
