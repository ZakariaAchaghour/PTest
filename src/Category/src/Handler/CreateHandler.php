<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
class CreateHandler implements RequestHandlerInterface
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
        $requestBody = $request->getParsedBody();
        if(empty($requestBody)){
         $result['_error']['error'] = 'missing_request';
         $result['_error']['error_description'] = 'No request body sent.';
         return new JsonResponse($result,400);
        } 
     
        $entity = new Category();
        try {
         $entity->setCategory($requestBody);
         $entity->setCreatedAt(new DateTime());
        $res =  $this->entityManager->persist($entity);
         $this->entityManager->flush();
        } catch (ORMException $e) {
         $result['_error']['error'] = 'Not created';
         $result['_error']['error_description'] = $e->getMessage();
         return new JsonResponse($result,400);
        }
         $resource = $this->resourceGenerator->fromObject($entity,$request);
         //return new JsonResponse($res,201);

         return $this->responseFactory->createResponse($request,$resource);
    }
}
