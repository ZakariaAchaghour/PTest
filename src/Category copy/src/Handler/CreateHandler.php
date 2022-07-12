<?php

declare(strict_types=1);

namespace Category\Handler;

use Exception;
use Category\Services\CategoryServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
class CreateHandler implements RequestHandlerInterface
{
    protected $categoryService;
    public function __construct(
        CategoryServiceInterface $categoryService
        )
    {
        $this->categoryService = $categoryService;
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        // Create and return a response
        $requestBody = $request->getParsedBody();
        $result['status'] = 201;

        try {
            $result['data'] = $this->categoryService->storeCategory($requestBody);
            $result['message'] = 'Category Created';
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return new JsonResponse($result, $result['status']);
    }
}
