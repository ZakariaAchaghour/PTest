<?php

declare(strict_types=1);

namespace Category\Handler;

use Product\Services\ProductServiceInterface;
use Psr\Container\ContainerInterface;

class ProductsCategoryHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ProductsCategoryHandler
    {
        $productService = $container->get(ProductServiceInterface::class);
        return new ProductsCategoryHandler($productService);
    }
}
