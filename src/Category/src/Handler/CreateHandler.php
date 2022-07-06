<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Category\Entity\CategoryServiceInterface;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Exception;
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

        // Create and return a response
        $requestBody = $request->getParsedBody();
        $result['status'] = 201;

        try {
            $result['message'] = 'Category Created';

            $result['data'] = $this->categoryService->storeCategory($requestBody);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        // if(empty($requestBody)){
        // $result = ['status' => 200];
        //  $result['_error']['error'] = 'missing_request';
        //  $result['_error']['error_description'] = 'No request body sent.';
        //  return new JsonResponse($result,400);
        // } 
     

        // $category = new Category();
       
        // try {
        //     $category->setName($requestBody['name']);
        //     if(empty($requestBody['slug'])){
               
        //         // $category->setSlug(str_slug($requestBody['name'] , "-"));
    
        //     }else{
        //         $category->setSlug($requestBody['slug']);
        //     }
        //     $category->setModifiedAt(new DateTime());
        //     $category->setCreatedAt(new DateTime());
        // //  $entity->setCategory($requestBody);
        // //  $entity->setCreatedAt(new DateTime());
        // $category = $this->categoryService->storeCategory($category);
        // // $res =  $this->entityManager->persist($entity);
        // //  $this->entityManager->flush();
        // } catch (ORMException $e) {
        //  $result['_error']['error'] = 'Not created';
        //  $result['_error']['error_description'] = $e->getMessage();
        //  return new JsonResponse($result,400);
        // }
        //  $resource = $this->resourceGenerator->fromObject($entity,$request);
        //  //return new JsonResponse($res,201);

        //  return $this->responseFactory->createResponse($request,$resource);
        return new JsonResponse($result, $result['status']);
    }
}
