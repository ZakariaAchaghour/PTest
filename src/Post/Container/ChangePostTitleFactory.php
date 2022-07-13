<?php

declare(strict_types=1);

namespace Post\Container;

use Post\App\Handlers\ChangePostTitleHandler;
use Post\App\Handlers\CreateHandler;
use Post\Model\Repository\PostRepository;
use Psr\Container\ContainerInterface;

class ChangePostTitleFactory
{
    public function __invoke(ContainerInterface $container) : ChangePostTitleHandler
    {
        $postRepository = $container->get(PostRepository::class);
        return new ChangePostTitleHandler($postRepository);
    }
}
