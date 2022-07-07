<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Container\ContainerInterface;

class EditHandlerFactory
{
    public function __invoke(ContainerInterface $container) : EditHandler
    {
        $categoryService = $container->get(CategoryServiceInterface::class);


        return new EditHandler(
            $categoryService
        );
    }
}
