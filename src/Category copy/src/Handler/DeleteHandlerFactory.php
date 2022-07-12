<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Container\ContainerInterface;

class DeleteHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteHandler
    {
        $categoryService = $container->get(CategoryServiceInterface::class);

        return new DeleteHandler($categoryService);
    }
}
