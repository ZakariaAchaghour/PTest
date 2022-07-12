<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $categoryService = $container->get(CategoryServiceInterface::class);
        
        return new ListHandler(
            $categoryService
            
        );
    }
}
