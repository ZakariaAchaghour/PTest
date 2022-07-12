<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Services\CategoryServiceInterface;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $responseFactory;
    protected $resourceGenerator;
    private $categoryService;
    public function __construct(
        CategoryServiceInterface $categoryService

        )
    {
        $this->categoryService = $categoryService;
        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['data'] = $this->categoryService->findCategory($id)->toArray(true);
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
       
        return new JsonResponse($result , $result['status']);
    }
}
