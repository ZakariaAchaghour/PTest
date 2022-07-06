<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\CategoryServiceInterface;
use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerInterface;

class EditHandlerFactory
{
    public function __invoke(ContainerInterface $container) : EditHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $responseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $categoryService = $container->get(CategoryServiceInterface::class);


        return new EditHandler(
            $entityManager,
            $responseFactory,
            $resourceGenerator,
            $categoryService
        );
    }
}
