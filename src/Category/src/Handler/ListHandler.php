<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Category\Entity\CategoryCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;

class ListHandler implements RequestHandlerInterface
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

        $repository = $this->entityManager->getRepository(Category::class)->findBy(array('deletedAt'=>null));

        // $query = $repository
        //     ->createQueryBuilder('c')
        //          ->where('c.deletedAt IS NULL')
        //     ->getQuery();
        // $query->setMaxResults('5');
        
        
        $collections = new CategoryCollection($repository);
        $resource  = $this->resourceGenerator->fromObject($collections, $request);
        return $this->responseFactory->createResponse($request, $resource);
       
    }
}
