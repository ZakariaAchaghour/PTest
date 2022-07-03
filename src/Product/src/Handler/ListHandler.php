<?php

declare(strict_types=1);

namespace Product\Handler;

use Doctrine\ORM\EntityManager;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Product\Entity\Product;
use Product\Entity\ProductCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
        
        $repository = $this->entityManager->getRepository(Product::class);
      
        $query = $repository
                    ->createQueryBuilder('p')
                    ->where('p.deletedAt IS NULL')
                    ->getQuery();
        $query->setMaxResults('5');
          
        $paginator = new ProductCollection($query);
        $resource  = $this->resourceGenerator->fromObject($paginator, $request);
       
        return $this->responseFactory->createResponse($request, $resource);
    }
}
