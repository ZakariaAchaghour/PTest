<?php

declare(strict_types=1);

namespace Category\Container;

use Category\App\Handlers\CreateCategoryHandler;
use Category\Model\Repository\CategoryRepository;
use Psr\Container\ContainerInterface;

class CreateCategoryHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateCategoryHandler
    {
        $categoryRepository = $container->get(CategoryRepository::class);
        return new CreateCategoryHandler($categoryRepository);
    }
}
