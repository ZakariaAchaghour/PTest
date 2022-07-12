<?php

declare(strict_types=1);

namespace Post\Container;

use Post\App\Handlers\ListHandler;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        return new ListHandler();
    }
}
