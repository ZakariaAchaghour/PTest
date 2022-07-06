<?php

declare(strict_types=1);

namespace Product\Handler;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Product\Entity\Product;
use Product\Services\ProductServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $productService;
    public function __construct(
        EntityManager $entityManager,
        ProductServiceInterface $productService

        )
    {
        $this->entityManager = $entityManager;
        $this->productService = $productService;

        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['message'] = 'Product Deleted';
            $result['data'] = $this->productService->deleteProduct($id);
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return new JsonResponse($result,$result['status']);
    }
}
