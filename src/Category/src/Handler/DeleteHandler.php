<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteHandler implements RequestHandlerInterface
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
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['message'] = 'Category Deleted';
            $result['data'] = $this->categoryService->deleteCategory($id);
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        
        return new JsonResponse($result , $result['status']);


    }
}
