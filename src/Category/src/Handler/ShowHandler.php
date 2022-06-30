<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Doctrine\ORM\EntityManager;
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
    public function __construct(
        EntityManager $entityManager,
        HalResponseFactory $responseFactory,
        ResourceGenerator $resourceGenerator
        )
    {
        $this->entityManager = $entityManager;
        $this->responseFactory = $responseFactory;
        $this->resourceGenerator = $resourceGenerator;
        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(array('id'=>$id  ,'deletedAt'=>null));
        if(empty($category)){
            $result['_error']['error'] = 'Not Found';
            $result['_error']['error_description'] = 'Record Not Found.';
            return new JsonResponse($result,404);
           } 
        $resource = $this->resourceGenerator->fromObject($category,$request);
        return $this->responseFactory->createResponse($request,$resource);
        
    }
}
