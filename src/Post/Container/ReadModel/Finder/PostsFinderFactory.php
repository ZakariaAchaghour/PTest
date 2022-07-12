<?php
declare(strict_types=1);

namespace Post\Container\ReadModel\Finder;

use Post\ReadModel\Finder\PostsFinder;
use Psr\Container\ContainerInterface;

class PostsFinderFactory
{
    public function __invoke(ContainerInterface $container): PostsFinder
    {
        return new PostsFinder($container->get('pdo.connection'));
    }
}