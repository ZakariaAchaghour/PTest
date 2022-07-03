<?php

declare(strict_types=1);

namespace Product\Handler;

use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Product\Entity\Product;
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
        // Create and return a response
        $id = $request->getAttribute('id');
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(array('id'=>$id  ,'deletedAt'=>null));
        if(empty($product)){
            $result['_error']['error'] = 'Not Found';
            $result['_error']['error_description'] = 'Record Not Found.';
            return new JsonResponse($result,404);
           } 
        $resource = $this->resourceGenerator->fromObject($product,$request);
        return $this->responseFactory->createResponse($request,$resource);
    }
}
