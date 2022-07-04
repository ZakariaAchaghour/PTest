<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditHandler implements RequestHandlerInterface
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
      
        $requestBody = $request->getParsedBody();
        if(empty($requestBody)){
         $result['_error']['error'] = 'missing_request';
         $result['_error']['error_description'] = 'No request body sent.';
         return new JsonResponse($result,400);
        } 
        $entity = $this->entityManager->getRepository(Category::class)->find($id);
       
        if(empty($entity)){
            $result['_error']['error'] = 'Not Found';
            $result['_error']['error_description'] = 'Record Not Found.';
            return new JsonResponse($result,404);
        } 
        try {
            $entity->setCategory($requestBody);
            $this->entityManager->merge($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $result['_error']['error'] = 'Not updated';
            $result['_error']['error_description'] = $e->getMessage();
            return new JsonResponse($result,400);
        }
        $resource = $this->resourceGenerator->fromObject($entity,$request);
         return $this->responseFactory->createResponse($request,$resource);
     
    }
}
