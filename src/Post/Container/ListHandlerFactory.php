<?php

declare(strict_types=1);

namespace Post\Container;

use Post\App\Handlers\ListHandler;
use Prooph\ServiceBus\QueryBus;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        $queryBus = $container->get(QueryBus::class);
        return new ListHandler($queryBus);
    }
}
