<?php

declare(strict_types=1);

namespace Post\Response;

use Prooph\HttpMiddleware\Response\ResponseStrategy;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use \Laminas\Diactoros\Response\JsonResponse as MezzioJsonResponse;
final class JsonResponse implements ResponseStrategy
{
    public function fromPromise(PromiseInterface $promise): ResponseInterface
    {
        $json = null;

        $promise->then(function ($data) use (&$json) {
            $json = $data;
        });

        return new MezzioJsonResponse($json);
    }

    public function withStatus(int $statusCode): ResponseInterface
    {
        return new MezzioJsonResponse([], $statusCode);
    }
}