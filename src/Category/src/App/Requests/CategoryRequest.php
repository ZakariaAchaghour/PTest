<?php

declare(strict_types=1);

namespace Category\App\Requests;

use Assert\Assert;
use Category\Model\ValueObjects\CategoryId;
use Category\Model\ValueObjects\Name;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryRequest implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // $response = $handler->handle($request);
        $data = $request->getParsedBody();
        try {
            $id = isset($data['id']) ? $data['id']: '';
            $name = isset($data['name']) ? $data['name']: '';
            $products = isset($data['products']) ? $data['products']: [];
            $id =  CategoryId::fromString($id);
            $name = Name::fromString($name);
            // Assert::that($name)->notEmpty('The Name field is required.')
            //                      ->string('The Name must be a string.')
            //                      ->minLength(3,'The Name must be greater than 3 characters.');
            // Assert::that($products, 'Products')->isArray('The Products must be an array.');
            
            $handler->handle($request);
        } catch (Exception $e) {
            
            $result = [
                'error' => $e->getMessage()
            ];
             return new JsonResponse($result, 400);
            
        }
    }
}
