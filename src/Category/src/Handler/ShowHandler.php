<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Category\Entity\CategoryServiceInterface;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use phpDocumentor\Reflection\Types\Null_;
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
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['data'] = $this->categoryService->findCategory($id)->toArray();
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        // if(empty($category)){
        //     $result['_error']['error'] = 'Not Found';
        //     $result['_error']['error_description'] = 'Record Not Found.';
        //     return new JsonResponse($result,404);
        //    } 
       
        return new JsonResponse($result , $result['status']);
    }
}
