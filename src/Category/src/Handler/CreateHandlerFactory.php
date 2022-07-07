<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Container\ContainerInterface;

class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateHandler
    {
        $categoryService = $container->get(CategoryServiceInterface::class);

        return new CreateHandler($categoryService);
    }
}
