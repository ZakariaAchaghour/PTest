<?php

declare(strict_types=1);

namespace Category\App\Requests;

use Psr\Container\ContainerInterface;

class CategoryRequestFactory
{
    public function __invoke(ContainerInterface $container) : CategoryRequest
    {
        return new CategoryRequest();
    }
}
