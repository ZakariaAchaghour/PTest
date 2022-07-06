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
        $id = $request->getAttribute('id');
        $requestBody = $request->getParsedBody();
        $result['status'] = 200;

        try {
            $result['message'] = 'Category Updated';

            $result['data'] = $this->categoryService->updateCategory($id,$requestBody);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    //     $id = $request->getAttribute('id');
      
    //     $requestBody = $request->getParsedBody();
    //     if(empty($requestBody)){
    //      $result['_error']['error'] = 'missing_request';
    //      $result['_error']['error_description'] = 'No request body sent.';
    //      return new JsonResponse($result,400);
    //     } 
    //    $category =  $this->categoryService->findCategory($id);
    //     if(empty($category)){
    //         $result['_error']['error'] = 'Not Found';
    //         $result['_error']['error_description'] = 'Record Not Found.';
    //         return new JsonResponse($result,404);
    //     } 
        
    //     try {
    //         $category->setName($requestBody['name']);
    //         if(empty($requestBody['slug'])){
    //             // $category->setSlug(str_slug($requestBody['name'] , "-"));
    //         }else{
    //             $category->setSlug($requestBody['slug']);
    //         }
    //         $category->setModifiedAt(new DateTime());
           
    //     } catch (ORMException $e) {
    //         $result['_error']['error'] = 'Not updated';
    //         $result['_error']['error_description'] = $e->getMessage();
    //         return new JsonResponse($result,400);
    //     }
        
        // $resource = $this->resourceGenerator->fromObject($entity,$request);
        //  return $this->responseFactory->createResponse($request,$resource);
     
        // $this->categoryService->updateCategory($id,$category);
        // return new JsonResponse(['message' => 'Category Updated' , 'Category' => $category->toArray()], 200);
        return new JsonResponse($result, $result['status']);

    }
}
