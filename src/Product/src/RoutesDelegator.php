<?php 

namespace Product;

use Psr\Container\ContainerInterface;
use Mezzio\Application;
use Product\Handler\CreateHandler;
use Product\Handler\DeleteHandler;
use Product\Handler\EditHandler;
use Product\Handler\ListHandler;
use Product\Handler\ShowHandler;

class RoutesDelegator 
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $callback) : Application 
    {
        $app = $callback();
        // setup routes 
      
        $app->get('/api/v1/products',ListHandler::class,'products.list');
        $app->get('/api/v1/products/{id}',ShowHandler::class,'products.show');
        $app->delete('/api/v1/products/{id}',DeleteHandler::class,'products.delete');
        $app->put('/api/v1/products/{id}',EditHandler::class,'products.edit');
        $app->post('/api/v1/products',CreateHandler::class,'products.create');

      
        return $app;
    }
}