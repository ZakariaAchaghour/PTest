<?php

declare(strict_types=1);

namespace Post\Actions;

use Prooph\ServiceBus\QueryBus;
use Psr\Container\ContainerInterface;

class PostsListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : PostsListHandler
    {
        $query = $container->get(QueryBus::class);
      
        return new PostsListHandler($query);
    }
}
