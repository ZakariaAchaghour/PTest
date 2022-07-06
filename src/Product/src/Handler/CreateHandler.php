<?php

declare(strict_types=1);

namespace Product\Handler;

use Category\Entity\Category;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Product\Services\ProductServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $responseFactory;
    protected $resourceGenerator;
    protected $productService;
    public function __construct(
        EntityManager $entityManager,
        HalResponseFactory $responseFactory,
        ResourceGenerator $resourceGenerator,
        ProductServiceInterface $productService

        )
    {
        $this->entityManager = $entityManager;
        $this->responseFactory = $responseFactory;
        $this->resourceGenerator = $resourceGenerator;
        $this->productService = $productService;

        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        $requestBody = $request->getParsedBody();
        $result['status'] = 201;

        try {
            $result['message'] = 'Product Created';

            $result['data'] = $this->productService->storeProduct($requestBody);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return new JsonResponse($result, $result['status']);

       
    }
}
