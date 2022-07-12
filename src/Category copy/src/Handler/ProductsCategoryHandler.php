<?php

declare(strict_types=1);

namespace Category\Handler;

use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Product\Services\ProductServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductsCategoryHandler implements RequestHandlerInterface
{

   
    private $productService;
    public function __construct(
        ProductServiceInterface $productService

        )
    {
        $this->productService = $productService;
        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['data'] = $this->productService->findProductsByCategory($id);
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
       
        return new JsonResponse($result , $result['status']);
    }
}
