<?php

declare(strict_types=1);

namespace Post\App\Handlers;

use Laminas\Diactoros\Response\JsonResponse;

use Post\ReadModel\Queries\FetchPosts;
use Post\ReadModel\Finder\PostsFinder;
use React\Promise\Deferred;

class ListHandler 
{
    private $postFinder;
    public function __construct(PostsFinder $postFinder)
    {
        $this->postFinder = $postFinder;
    }
    public function __invoke(FetchPosts $query, Deferred $deferred = null)
    {
        var_dump('ok');
        die;
        $posts = $this->postFinder->findAll();
        if (null === $deferred) {
            return $posts;
        }

        $deferred->resolve($posts);
    }
}
