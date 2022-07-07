<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;

class ListHandler implements RequestHandlerInterface
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
        $result = ['status' => 200];
        try {
            $result['data'] = $this->categoryService->findAllCategories();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return  new JsonResponse($result , $result['status']);
    }
}
