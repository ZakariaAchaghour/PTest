<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Container\ContainerInterface;

class ShowHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ShowHandler
    {
        $categoryService = $container->get(CategoryServiceInterface::class);


        return new ShowHandler(
            $categoryService
        );
    }
}
