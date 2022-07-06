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

class DeleteHandler implements RequestHandlerInterface
{
    protected $entityManager;
    protected $categoryService;

    public function __construct(
        EntityManager $entityManager,
        CategoryServiceInterface $categoryService

        )
    {
        $this->entityManager = $entityManager;
        $this->categoryService = $categoryService;

        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Create and return a response
        $id = $request->getAttribute('id');
        $result = ['status' => 200];
        try {
            $result['message'] = 'Category Deleted';
            $result['data'] = $this->categoryService->deleteCategory($id);
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        // $category = $this->categoryService->findCategory($id);
        // if(empty($category)){
        //     $result['_error']['error'] = 'Not Found';
        //     $result['_error']['error_description'] = 'Record Not Found.';
        //     return new JsonResponse($result,404);
        // } 

        // try {
        //     $category->setDeletedAt(new DateTime());
        //     $this->categoryService->deleteCategory($category);
           
        // } catch (ORMException $e) {
        //     $result['_error']['error'] = 'Not updated';
        //     $result['_error']['error_description'] = $e->getMessage();
        //     return new JsonResponse($result,400);
        // }

        return new JsonResponse($result , $result['status']);


    }
}
