<?php

declare(strict_types=1);

namespace Product\Handler;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Laminas\Diactoros\Response\JsonResponse;
use Product\Entity\Product;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteHandler implements RequestHandlerInterface
{
    protected $entityManager;

    public function __construct(
        EntityManager $entityManager
        )
    {
        $this->entityManager = $entityManager;
        
    }
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Create and return a response
        $id = $request->getAttribute('id');
        $entity = $this->entityManager->getRepository(Product::class)->find($id);
        if(empty($entity)){
            $result['_error']['error'] = 'Not Found';
            $result['_error']['error_description'] = 'Record Not Found.';
            return new JsonResponse($result,404);
        } 

        try {
            $entity->setDeletedAt(new DateTime());
            $this->entityManager->merge($entity);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $result['_error']['error'] = 'Not Deleted';
            $result['_error']['error_description'] = $e->getMessage();
            return new JsonResponse($result,400);
        }

        return new JsonResponse([
                        'message' => 'Product Deleted!',
                        'product' => null
                    ]);
    }
}
