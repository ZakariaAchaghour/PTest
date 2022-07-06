<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\CategoryServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;

class ListHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $responseFactory;
    protected $resourceGenerator;
    protected $categoryService;
    public function __construct(
        EntityManager $entityManager,
        HalResponseFactory $responseFactory,
        ResourceGenerator $resourceGenerator,
        CategoryServiceInterface $categoryService
        )
    {
        $this->entityManager = $entityManager;
        $this->responseFactory = $responseFactory;
        $this->resourceGenerator = $resourceGenerator;
        $this->categoryService = $categoryService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {        
        $result = ['status' => 200];
        try {
            $result['data'] = $this->categoryService->findAllCategories();
            var_dump($result['data']);
            die;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        //  $collections = new CategoryCollection($categories);
        // $resource  = $this->resourceGenerator->fromObject($collections, $request);
        // return $this->responseFactory->createResponse($request, $resource);
        return  new JsonResponse($result , $result['status']);
       
    }
}
