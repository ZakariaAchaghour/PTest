<?php

declare(strict_types=1);

namespace Post\Container;

use Post\App\Handlers\ListHandler;
use Post\ReadModel\Finder\PostsFinder;
use Prooph\ServiceBus\QueryBus;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $postFinder = $container->get(PostsFinder::class);
        return new ListHandler($postFinder);
    }
}
