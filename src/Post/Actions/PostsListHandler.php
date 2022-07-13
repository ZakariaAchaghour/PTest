<?php

declare(strict_types=1);

namespace Post\Actions;

use Laminas\Diactoros\Response\JsonResponse;
use Post\ReadModel\Queries\FetchPosts;
use Prooph\ServiceBus\QueryBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PostsListHandler implements RequestHandlerInterface
{
     /**
     * @var QueryBus
     */
    private $queryBus;


    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Create and return a response
        
        $results = [];

        $promise = $this->queryBus->dispatch(new FetchPosts());
        
        $promise->then(function ($result) use (&$results): void {
            $results = $result;
             
        });

        return new JsonResponse($results,200);
    }
}
