<?php

declare(strict_types=1);

namespace Post\Container;

use Post\App\Handlers\CreateHandler;
use Post\Model\Repository\PostRepository;
use Psr\Container\ContainerInterface;

class CreateHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateHandler
    {
        $postRepository = $container->get(PostRepository::class);
        return new CreateHandler($postRepository);
    }
}
