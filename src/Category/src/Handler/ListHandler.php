<?php

declare(strict_types=1);

namespace Category\Handler;

use Category\Entity\Category;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Laminas\Diactoros\Response\JsonResponse;

class ListHandler implements RequestHandlerInterface
{
    protected $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $q = $this->entityManager->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->getQuery();
             $paginator = new Paginator($q);
             $records = $paginator->getQuery()
                                  ->getResult(Query::HYDRATE_ARRAY);

            $result['_embedded']['categories'] = $records;
            return new JsonResponse($result);
    }
}
