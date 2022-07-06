<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\CategoryServiceInterface;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateHandler
    {
        $entityManager = $container->get(EntityManager::class);
        $responseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $categoryService = $container->get(CategoryServiceInterface::class);

        return new CreateHandler(
            $entityManager,
            $responseFactory,
            $resourceGenerator,
            $categoryService
        );
    }
}
